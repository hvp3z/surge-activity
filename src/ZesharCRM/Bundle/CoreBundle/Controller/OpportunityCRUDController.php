<?php

namespace ZesharCRM\Bundle\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sonata\AdminBundle\Controller\CRUDController as CRUDController;
use ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject;
use ZesharCRM\Bundle\CoreBundle\Entity\Opportunity;
use ZesharCRM\Bundle\CoreBundle\Enum\OpportunityStatus;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use ZesharCRM\Bundle\CoreBundle\Event\CustomEvent;
use Symfony\Component\HttpFoundation\Request;
use ZesharCRM\Bundle\CoreBundle\Helper\Filter\FilterQuotes;
use ZesharCRM\Bundle\CoreBundle\Entity\Lead;
use ZesharCRM\Bundle\CoreBundle\Enum\LeadType;
use ZesharCRM\Bundle\CoreBundle\Repository\LeadRepository;


class OpportunityCRUDController extends CRUDController
{
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

        if ($this->getRestMethod() == 'POST') {
            $form->submit($this->get('request'));

            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                if (false === $this->admin->isGranted('CREATE', $object)) {
                    throw new AccessDeniedException();
                }

                /** @var $em \Doctrine\ORM\EntityManager */
                $em = $this->getDoctrine()->getManager();

                $creator = $this->getUser();
                $assignee = $object->getAssignee();

                //$this->admin->create($object);


                $lead = new Lead();

                $lead
                    ->setName($object->getLeadCategory()->getTitle())
                    ->setStatus($object->getStatus())
                    ->setType(LeadType::COLD)
                    ->setCreator($creator)
                    ->setAssignee($assignee)
                    ->setContactCard($object->getContactCard())
                    ->setLeadCategory($object->getLeadCategory())
                ;
                $em->persist($lead);
                $em->flush();

                $opportunity = new Opportunity();

                // copy all fields
                $opportunity
                    ->setLead($lead)
                    ->setName($object->getName())
                    ->setStatus($object->getStatus())
                    ->setCreator($lead->getCreator())
                    ->setAssignee($lead->getAssignee())
                    ->setContactCard($lead->getContactCard())
                    ->setOpportunityCategory($lead->getLeadCategory())
                    ->setPurchaseAmount($object->getPurchaseAmount())
                    ->setPurchasedAt($object->getPurchasedAt())
                    ->setEstimatedValue($object->getEstimatedValue())
                ;

                $em->persist($opportunity);
                $em->flush($lead);

                try {
                    //$object = $this->admin->create($opportunity);

                    $object = $opportunity;

                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson(array(
                            'result'   => 'ok',
                            'objectId' => $this->admin->getNormalizedIdentifier($object),
                        ));
                    }

                    $this->addFlash(
                        'sonata_flash_success',
                        $this->admin->trans(
                            'flash_create_success',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );

                    // redirect to edit mode
                    return $this->redirectTo($object);
                } catch (ModelManagerException $e) {
                    $this->logModelManagerException($e);

                    $isFormValid = false;
                }
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash(
                        'sonata_flash_error',
                        $this->admin->trans(
                            'flash_create_error',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );
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



    /**
     * return the Response object associated to the view action
     *
     * @param null $id
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return Response
     */
    public function showAction($id = null)
    {
        $id = $this->get('request')->get($this->admin->getIdParameter());

        $object = $this->admin->getObject($id);

        if (!$object || ($object->getStatus() === OpportunityStatus::SUCCESS_QUOTE && !$this->container->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) || $object->getStatus() === OpportunityStatus::CANCELLED_OPPORTUNITY ) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        if (false === $this->admin->isGranted('VIEW', $object)) {
            throw new AccessDeniedException();
        }

        $this->admin->setSubject($object);

        $form = $this->admin->getForm();
        $form->setData($object);
        $formView = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFormTheme());

        return $this->render($this->admin->getTemplate('show'), array(
            'action'   => 'show',
            'object'   => $object,
            'form' => $formView,
            'elements' => $this->admin->getShow(),
          ));
    }

    public function closeOpportunityAction() {
        $opportunity = $this->lookupOpportunity();

        if ($opportunity->getStatus() === OpportunityStatus::PENDING_OPPORTUNITY) {
            $opportunityRepository = $this->getRepository();
            $opportunityRepository->closeOpportunity($opportunity);
            $this->addFlash('sonata_flash_success', sprintf('Opportunity "%s" was converted to quote.', $opportunity->getName()));
        } else {
            $this->addFlash('sonata_flash_error', 'Cannot convert opportunity to quote - it was already closed before.');
        }

        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    public function cancelOpportunityAction()
    {
        $opportunity = $this->lookupOpportunity();

        if ($opportunity->getStatus() === OpportunityStatus::PENDING_OPPORTUNITY) {
            $opportunityRepository = $this->getRepository();
            $opportunityRepository->cancelOpportunity($opportunity);
            $this->addFlash('sonata_flash_success', sprintf('Opportunity "%s" was cancelled.', $opportunity->getName()));
        } else {
            $this->addFlash('sonata_flash_error', 'Cannot cancel a Opportunity - it was already closed before.');
        }

        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    public function cancelQuoteAction()
    {
        $opportunity = $this->lookupOpportunity();

        if ($opportunity->getStatus() === OpportunityStatus::PENDING_QUOTE) {
            $opportunityRepository = $this->getRepository();
            $opportunityRepository->cancelQuote($opportunity);
            $event = new CustomEvent();
            $event->setLead($opportunity->getLead());
            $dispatcher = $this->container->get('event_dispatcher');
            $dispatcher->dispatch('regeneration.setToLead',$event);
            $this->addFlash('sonata_flash_success', sprintf('Quote "%s" was cancelled.', $opportunity->getName()));
            if($event->getRedirectUrl()) {
                return new RedirectResponse($event->getRedirectUrl());
            }
        } else {
            $this->addFlash('sonata_flash_error', 'Cannot cancel a quote - it was already closed before.');
        }

        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    public function closeQuoteAction()
    {
        $opportunity = $this->lookupOpportunity();

        if ($opportunity->getStatus() === OpportunityStatus::PENDING_QUOTE) {
            $opportunityRepository = $this->getRepository();
            $opportunityRepository->closeQuote($opportunity);

            $event = new CustomEvent();
            $event->setLead($opportunity->getLead());
            $event->setProduct($opportunity->getOpportunityCategory());
            $dispatcher = $this->container->get('event_dispatcher');
            $dispatcher->dispatch('regeneration.setToProduct',$event);

            $this->addFlash('sonata_flash_success', sprintf('Quote "%s" was sold.', $opportunity->getName()));
            if($event->getRedirectUrl()) {
                return new RedirectResponse($event->getRedirectUrl());
            }
        } else {
            $this->addFlash('sonata_flash_error', 'Cannot close a Quote - it was already closed before.');
        }

        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    public function updateAction($opportunity= null)
    {

        $OpportunityScoring = $this->container->get('sonata.admin.pool')->getAdminByAdminCode('zeshar_crm_lead_scoring.admin.lead_scoring');
        $url = $OpportunityScoring->generateUrl('scoring',array('opportunity'=>$opportunity));
        return new RedirectResponse($url);
    }

    private function lookupOpportunity() {
        $id = $this->get('request')->get($this->admin->getIdParameter());

        $opportunity = $this->admin->getObject($id);

        if (!$opportunity) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        return $opportunity;
    }

    private function getRepository() {
        return $this->getDoctrine()->getRepository('ZesharCRM\Bundle\CoreBundle\Entity\Opportunity');
    }


    public function listAction()
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        $datagrid = $this->admin->getDatagrid();
        $datagrid->getQuery()->getQueryBuilder()->andWhere('o.status = :status')->setParameter('status', OpportunityStatus::PENDING_OPPORTUNITY);

        $formView = $datagrid->getForm()->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

        return $this->render($this->admin->getTemplate('list'), array(
            'action'     => 'list',
            'form'       => $formView,
            'datagrid'   => $datagrid,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
        ));
    }

    public function listQuoteAction(Request $request)
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        $datagrid = $this->admin->getDatagrid();
        // if (!$this->container->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
        //     $datagrid->getQuery()->getQueryBuilder()->andWhere('o.isArchive = :isArchive')->setParameter('isArchive', false);
        // }
        $datagrid->getQuery()->getQueryBuilder()->andWhere('o.status = :status')->setParameter('status', OpportunityStatus::PENDING_QUOTE);

        $formView = $datagrid->getForm()->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

        return $this->render($this->admin->getTemplate('list'), array(
            'action'     => 'listQuote',
            'form'       => $formView,
            'datagrid'   => $datagrid,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
        ));
    }

    public function SoldQuoteAction(Request $request)
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        $datagrid = $this->admin->getDatagrid();
        // if (!$this->container->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
        //     $datagrid->getQuery()->getQueryBuilder()->andWhere('o.isArchive = :isArchive')->setParameter('isArchive', false);
        // }
        $datagrid->getQuery()->getQueryBuilder()->andWhere('o.status = :status')->setParameter('status', OpportunityStatus::SUCCESS_QUOTE);

        $formView = $datagrid->getForm()->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

        return $this->render($this->admin->getTemplate('list'), array(
            'action'     => 'SoldQuote',
            'form'       => $formView,
            'datagrid'   => $datagrid,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
        ));
    }

    public function listOpportunityAction(Request $request)
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        $datagrid = $this->admin->getDatagrid();
        // if (!$this->container->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
        //     $datagrid->getQuery()->getQueryBuilder()->andWhere('o.isArchive = :isArchive')->setParameter('isArchive', false);
        // }
        $datagrid->getQuery()->getQueryBuilder()->andWhere('o.status = :status')->setParameter('status', OpportunityStatus::PENDING_OPPORTUNITY);

        $formView = $datagrid->getForm()->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

        return $this->render($this->admin->getTemplate('list'), array(
            'action'     => 'listOpportunity',
            'form'       => $formView,
            'datagrid'   => $datagrid,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
        ));
    }


    private function logModelManagerException($e)
    {
        $context = array('exception' => $e);
        if ($e->getPrevious()) {
            $context['previous_exception_message'] = $e->getPrevious()->getMessage();
        }
        $this->getLogger()->error($e->getMessage(), $context);
    }
}
