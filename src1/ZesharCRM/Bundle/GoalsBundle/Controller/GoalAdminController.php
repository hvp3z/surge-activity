<?php

namespace ZesharCRM\Bundle\GoalsBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sonata\AdminBundle\Controller\CRUDController as CRUDController;
use ZesharCRM\Bundle\CoreBundle\Enum\GoalKind;


class GoalAdminController extends CRUDController
{
    public function createAction()
    {
        $templateKey = 'edit';

        if (false === $this->admin->isGranted('CREATE')) {
            throw new AccessDeniedException();
        }

        $object = $this->admin->getNewInstance();

        $this->admin->setSubject($object);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->admin->getForm();

        $form->setData($object);

        $salesPerson = $this->getDoctrine()->getRepository('ZesharCRMCoreBundle:User')->findByRole('ROLE_SALES_PERSON');

        if ($this->getRestMethod()== 'POST') {

            $form->submit($this->get('request'));

            $isFormValid = $form->isValid();

            $year = new \DateTime('01-01-'.$form->get('year-goal')->getData());

            //check was created goal before
            $goal = $this->getDoctrine()->getRepository('ZesharCRMGoalsBundle:Goal')->findOneBy(array('goalCategory' => $object->getGoalCategory(), 'startsAt' => $year));

            //find sales in $year
            $performance = $this->getDoctrine()->getRepository('ZesharCRMCoreBundle:Operation')->getPrevYearPerformance(clone $year);
            $categoryPerformance = array();
            foreach ($performance as $item) {
                $entity = $this->getDoctrine()->getRepository('ZesharCRMCoreBundle:Opportunity')->findOneById($item->getEntity());
                if ($entity && $object->getGoalCategory() == $entity->getOpportunityCategory()) {
                    $categoryPerformance[] = $entity;
                }
            }

//            $form->get('count')->setData(count($performance));
            if ($form->get('countPrevYear')->getData()) {
                $total = $form->get('countPrevYear')->getData();
            } else {
                $total = count($categoryPerformance);
            }

            $object->setTotal($total);

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {

                if (false === $this->admin->isGranted('CREATE', $object)) {
                    throw new AccessDeniedException();
                }

                if (empty($goal)) {
                    if ($total > 0 ) {
                    $count = 1;

                    for ($i = 1; $i <= $count; $i++) {
                        $child = $this->admin->getNewInstance();
                        $child->setDescription($object->getDescription());
                        $child->setGoalCategory($object->getGoalCategory());
                        $child->setEstimated($object->getEstimated()/$count);
                        $child->setTotal($object->getTotal());

                        $child->setStartsAt(clone $year);
                        $child->setFinishesAt($year->modify("+".(12/$count)."month"));
                        $child->setCreator($object->getCreator());
                        $this->admin->create($child);

                        $goalRepository = $this->getRepository();
                        $goalRepository->createGoalAssignment($child,$salesPerson,$count);

                    }

                    $this->addFlash('sonata_flash_success', 'Goals has been successfully created.');

                    // redirect to list
                    return new RedirectResponse($this->admin->generateUrl('list'));
                    } else {
                        $this->addFlash('sonata_flash_error', 'Cannot create goal, estimated count is zero!');
                    }
                } else {
                    $this->addFlash('sonata_flash_error', 'Cannot create goal, it was created before!');
                }
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash('sonata_flash_error', $this->admin->trans('flash_create_error', array('%name%' => $this->admin->toString($object)), 'SonataAdminBundle'));
                }
            } elseif ($this->isPreviewRequested()) {
                // pick the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

        return $this->render($this->admin->getTemplate($templateKey), array(
            'action' => 'create',
            'form'   => $view,
            'object' => $object,
        ));

    }

    private function getRepository() {
        return $this->getDoctrine()->getRepository('ZesharCRM\Bundle\GoalsBundle\Entity\Goal');
    }

}
