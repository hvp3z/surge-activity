<?php

namespace ZesharCRM\Bundle\LeadScoringBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use ZesharCRM\Bundle\CoreBundle\Entity\Lead;
use ZesharCRM\Bundle\CoreBundle\Entity\Opportunity;
use ZesharCRM\Bundle\LeadScoringBundle\Entity\LeadScoring;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LeadScoringAdminController extends CRUDController
{
    public function scoringAction()
    {
        $requestData = $this->get('request')->query->all();

        $lead = $this->get('request')->query->get('lead');

        $opportunity = $this->get('request')->query->get('opportunity');

        $em = $this->getDoctrine();

        if ($lead) {
            $entity = $em->getRepository('ZesharCRMCoreBundle:Lead')->findOneById($lead);
            $parameter = array('lead'=>$entity);
            $leadContainer = $this->container->get('sonata.admin.pool')->getAdminByAdminCode('zeshar_crm_core.admin.lead');
            $url = $leadContainer->generateUrl('list');
        } else if ($opportunity) {
            $entity = $em->getRepository('ZesharCRMCoreBundle:Opportunity')->findOneById($opportunity);
            $parameter = array('opportunity'=>$entity);
            $opportunityContainer = $this->container->get('sonata.admin.pool')->getAdminByAdminCode('zeshar_crm_core.admin.opportunity');
            $url = $opportunityContainer->generateUrl('list');
        }

        $leadScoring = $em->getRepository('ZesharCRMLeadScoringBundle:LeadScoring')->findOneBy($parameter);

        $firstCriteria = $em->getRepository('ZesharCRMLeadScoringBundle:ScoringCriteria')->findBy(array('parent' => null));

        if (!$leadScoring) {
            $leadScoring = new LeadScoring();
            if ($entity instanceof Lead) {
                $leadScoring->setLead($entity);
                if ($entity->getOpportunity()) {
                    $leadScoring->setOpportunity($entity->getOpportunity());
                }
            } else if ($entity instanceof Opportunity) {
                $leadScoring->setOpportunity($entity);
                if ($entity->getLead()) {
                    $leadScoring->setLead($entity->getLead());
                }
            }

            $leadScoring->setScoring(serialize(array()));
            $leadScoring->setTotal(0);
            $em->getManager()->persist($leadScoring);
            $em->getManager()->flush($leadScoring);
        }


        $object = $this->admin->getObject($leadScoring->getId());

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $leadScoring->getId()));
        }

        if (false === $this->admin->isGranted('EDIT', $object)) {
            throw new AccessDeniedException();
        }

        $this->admin->setSubject($object);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->admin->getForm();

        $form->setData($object);

        if ($this->getRestMethod() == 'POST') {
            $form->submit($this->get('request'));

            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                $this->admin->update($object);

                if ($this->isXmlHttpRequest()) {
                    return $this->renderJson(array(
                        'result'    => 'ok',
                        'objectId'  => $this->admin->getNormalizedIdentifier($object)
                    ));
                }

                $this->addFlash('sonata_flash_success', $this->admin->trans('flash_edit_success', array('%name%' => $this->admin->toString($object)), 'SonataAdminBundle'));

                // redirect to edit mode
                return new RedirectResponse($url);
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash('sonata_flash_error', $this->admin->trans('flash_edit_error', array('%name%' => $this->admin->toString($object)), 'SonataAdminBundle'));
                }
            } elseif ($this->isPreviewRequested()) {
                // enable the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

        return $this->render('ZesharCRMLeadScoringBundle:ScoringCRUD:custom_edit_form.html.twig', array(
            'action' => 'scoring',
            'form'   => $view,
            'object' => $object,
            'firstCriteria' => $firstCriteria,
            'lead' => $lead,
            'opportunity' => $opportunity
        ));
    }

}
