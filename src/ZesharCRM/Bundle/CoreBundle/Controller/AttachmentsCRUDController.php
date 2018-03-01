<?php

namespace ZesharCRM\Bundle\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sonata\AdminBundle\Controller\CRUDController as CRUDController;

class AttachmentsCRUDController extends CRUDController
{
    
    public function createAction() {
        $original = parent::createAction();
        
        $request = $this->get('request');
        if ($request->getMethod() == 'POST' && $this->get('session')->has('zsh_attachment_redirect_url') ) {
            $redirect = $this->get('session')->get('zsh_attachment_redirect_url');
            $this->get('session')->remove('zsh_attachment_redirect_url');
            
            if (null !== $this->get('request')->get('btn_create_and_list')) {
                return new RedirectResponse($this->admin->generateUrl('list'));
            }
            
            return new RedirectResponse($redirect);
        } else {
            return $original;
        }
    }
    
    public function editAction($id = null) {
        $original = parent::editAction();
        
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            
            if (null !== $this->get('request')->get('btn_update_and_list')) {
                return new RedirectResponse($this->admin->generateUrl('list'));
            }
            
            $redirect = NULL;
            $id = $this->get('request')->get($this->admin->getIdParameter());
            if ($object = $this->admin->getObject($id)) {
                if ( ($leadAttachment = $object->getLeadAttachment()) && ($lead = $leadAttachment->getLead()) ) {
                    $redirect = $this
                        ->get('zeshar_crm_core.admin.lead')
                        ->generateUrl('show', array(
                                'id' => $lead->getId(),
                            )
                        );
                } elseif ( ($opportunityAttachment = $object->getOpportunityAttachment()) && ($opportunity = $opportunityAttachment->getOpportunity()) ) {
                    $redirect = $this
                        ->get('zeshar_crm_core.admin.opportunity')
                        ->generateUrl('show', array(
                                'id' => $opportunity->getId(),
                            )
                        );
                }
            }
            if ($redirect) {
                return new RedirectResponse($redirect);
            }
        }
        return $original;
    }
    
    public function deleteAction($id) {
        $id     = $this->get('request')->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        if (false === $this->admin->isGranted('DELETE', $object)) {
            throw new AccessDeniedException();
        }

        if ($this->getRestMethod() == 'DELETE') {
            // check the csrf token
            $this->validateCsrfToken('sonata.delete');

            try {
                $this->admin->delete($object);

                if ($this->isXmlHttpRequest()) {
                    return $this->renderJson(array('result' => 'ok'));
                }

                $this->addFlash(
                    'sonata_flash_success',
                    $this->admin->trans(
                        'flash_delete_success',
                        array('%name%' => $this->admin->toString($object)),
                        'SonataAdminBundle'
                    )
                );

            } catch (ModelManagerException $e) {

                if ($this->isXmlHttpRequest()) {
                    return $this->renderJson(array('result' => 'error'));
                }

                $this->addFlash(
                    'sonata_flash_error',
                    $this->admin->trans(
                        'flash_delete_error',
                        array('%name%' => $this->admin->toString($object)),
                        'SonataAdminBundle'
                    )
                );
            }
            
            $redirect = NULL;
            if ( ($leadAttachment = $object->getLeadAttachment()) && ($lead = $leadAttachment->getLead()) ) {
                $redirect = $this
                    ->get('zeshar_crm_core.admin.lead')
                    ->generateUrl('show', array(
                            'id' => $lead->getId(),
                        )
                    );
            } elseif ( ($opportunityAttachment = $object->getOpportunityAttachment()) && ($opportunity = $opportunityAttachment->getOpportunity()) ) {
                $redirect = $this
                    ->get('zeshar_crm_core.admin.opportunity')
                    ->generateUrl('show', array(
                            'id' => $opportunity->getId(),
                        )
                    );
            }

            if (!$redirect) {
                $redirect = $this->admin->generateUrl('list');
            }
            return new RedirectResponse($redirect);
        }

        return $this->render($this->admin->getTemplate('delete'), array(
            'object'     => $object,
            'action'     => 'delete',
            'csrf_token' => $this->getCsrfToken('sonata.delete')
        ));
    }
    
}
