<?php

namespace ZesharCRM\Bundle\LeadScoringBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;

class ScoringCriteriaAdminController extends CRUDController
{

    public $data = array();

    public function listAction()
    {

        $datagrid = $this->admin->getDatagrid();
        $formView = $datagrid->getForm()->createView();

        $tree = $this->showTree(null,$datagrid->getResults());

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());
        $string = $this->render('ZesharCRMLeadScoringBundle:ScoringCRUD:list_scoring.html.twig', array(
            'action'     => 'list',
            'form'       => $formView,
            'datagrid'   => $datagrid,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
            'entities'   => $this->data
        ));

        return $string;
    }

    private function showTree($ParentID, $entities, $string = '', $lvl = 0) {
        if ($entities) {
            $string .= '<ul>';
            foreach($entities as $entity){
                $entityParentId = $entity->getParent() ? $entity->getParent()->getId() : null;
                if ($entityParentId == $ParentID){
                    $this->data[] = $entity;
                    $string .= '<li>'.$entity->getName();
//                    $entity->setName(str_repeat(' ',$lvl).$entity->getName());
                    $lvl++;
                    $string = $this->showTree($entity->getId(), $entities, $string, $lvl);
                    $lvl--;
                    $string .= '</li>';
                }
            }
            $string .= '</ul>';
        }
        return $string;
    }

    public function editAction($id = null)
    {
        // the key used to lookup the template
        $templateKey = 'edit';

        $id = $this->get('request')->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
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

            $criteria = $this->getDoctrine()->getRepository('ZesharCRMLeadScoringBundle:ScoringCriteria')->findBy(array('parent'=>$object->getParent()));

            $percent = 100;

            foreach ($criteria as $value ) {
                if ($value->getId()!==$object->getId()) {
                    $percent -= $value->getScore();
                }
            }

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                if ($percent > 0 && $object->getScore() <= $percent) {
                    $this->admin->update($object);

                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson(array(
                            'result'    => 'ok',
                            'objectId'  => $this->admin->getNormalizedIdentifier($object)
                        ));
                    }

                    $this->addFlash('sonata_flash_success', $this->admin->trans('flash_edit_success', array('%name%' => $this->admin->toString($object)), 'SonataAdminBundle'));

                    // redirect to edit mode
                    return $this->redirectTo($object);
                } else {
                    $this->addFlash('error','Criteria exceeded 100 percent. Please edit current criteria or others. Score not be more than '.$percent);
                }
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

        return $this->render($this->admin->getTemplate($templateKey), array(
            'action' => 'edit',
            'form'   => $view,
            'object' => $object,
        ));
    }

    public function createAction()
    {
        // the key used to lookup the template
        $templateKey = 'edit';

        if (false === $this->admin->isGranted('CREATE')) {
            throw new AccessDeniedException();
        }

        $object = $this->admin->getNewInstance();

        $this->admin->setSubject($object);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->admin->getForm();
        $form->setData($object);

        if ($this->getRestMethod()== 'POST') {
            $form->submit($this->get('request'));

            $creator = $this->getLoggedInUser();
            $company = $creator->getCompany();

            $object->setCompany($company);

            $isFormValid = $form->isValid();

            $criteria = $this->getDoctrine()->getRepository('ZesharCRMLeadScoringBundle:ScoringCriteria')->findBy(array('parent'=>$object->getParent()));

            $percent = 100;

            foreach ($criteria as $value ) {
                $percent -= $value->getScore();
            }

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {

                if (false === $this->admin->isGranted('CREATE', $object)) {
                    throw new AccessDeniedException();
                }

                if ($percent > 0 && $object->getScore() <= $percent) {

                    $this->admin->create($object);

                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson(array(
                            'result' => 'ok',
                            'objectId' => $this->admin->getNormalizedIdentifier($object)
                        ));
                    }

                    $this->addFlash('sonata_flash_success', $this->admin->trans('flash_create_success', array('%name%' => $this->admin->toString($object)), 'SonataAdminBundle'));

                    // redirect to edit mode
                    return $this->redirectTo($object);
                } else {
                    $this->addFlash('error','Criteria exceeded 100 percent. Please edit current criteria or others. Score not be more than '.$percent);
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

    private function getLoggedInUser()
    {
        if ($user = $this->container->get('security.context')->getToken()->getUser()) {
            return $user;
        }
        return NULL;
    }

}
