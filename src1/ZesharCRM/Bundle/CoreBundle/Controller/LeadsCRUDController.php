<?php

namespace ZesharCRM\Bundle\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sonata\AdminBundle\Controller\CRUDController as CRUDController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use ZesharCRM\Bundle\CoreBundle\Enum\DealStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\LeadType;
use ZesharCRM\Bundle\CoreBundle\Controller\OpportunityCRUDController;
use ZesharCRM\Bundle\CoreBundle\Event\CustomEvent;
use ZesharCRM\Bundle\CoreBundle\Entity\Lead;
use Symfony\Component\HttpFoundation\Request;

class LeadsCRUDController extends CRUDController
{
    /**
     * return the Response object associated to the create action
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @return Response
     */
    public function createAction()
    {
        $object = $this->admin->getNewInstance();
        $this->admin->setSubject($object);

        $form = $this->admin->getForm();
        $form->setData($object);
        $formView = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFormTheme());

        if (false === $this->admin->isGranted('VIEW', $object)) {
            throw new AccessDeniedException();
        }

        $this->admin->setSubject($object);

        $em = $this->getDoctrine()->getManager();
        $em->persist($object);
        $user = $this->container->get('security.context')->getToken()->getUser();
        /**
         * @var Lead $object
         */
        $object
          ->setName('Lead')
          ->setStatus(DealStatus::PENDING)
          ->setType(LeadType::COLD)
          ->setCreator($user)
          ->setAssignee($user);

        $em->flush();
        return $this->render($this->admin->getTemplate('create'), array(
            'action'   => 'show',
            'object'   => $object,
            'form' => $formView,
            'elements' => $this->admin->getShow(),
          ));
    }

    public function listLeadsAction(Request $request)
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        $datagrid = $this->admin->getDatagrid();
        // if (!$this->container->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
        //     $part = $datagrid->getQuery()->getQueryBuilder();
        //     $alias = $part->getDqlPart('from')[0]->getAlias();
        //     $datagrid->getQuery()->getQueryBuilder()->andWhere($alias.'.isArchive = :isArchive')->setParameter('isArchive', false);
        // }

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

    public function showAction($id = null)
    {
        $id = $this->get('request')->get($this->admin->getIdParameter());

        $object = $this->admin->getObject($id);

        if (!$object || $object->getStatus() !=  DealStatus::PENDING) {
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

    public function closeAction()
    {
        $lead = $this->lookupLead();
        $leadRepository = $this->getRepository();
        $entity = $this->getDoctrine()->getRepository('ZesharCRM\Bundle\CoreBundle\Entity\Opportunity')->findOneBy(array('lead'=>$lead->getId()));
        $opportunityContainer = $this->container->get('sonata.admin.pool')->getAdminByAdminCode('zeshar_crm_core.admin.opportunity');
        if ($lead->getStatus() === DealStatus::PENDING && empty($entity)) {
             $object = $leadRepository->createOpportunity($lead);
             $url = $opportunityContainer->generateObjectUrl('edit', $object);
             $name = '<a href="'.$url.'">'.$lead->getName().'</a>';
             $this->addFlash('sonata_flash_success', sprintf('Lead was closed as success and an opportunity was created. "%s"', $name));
        } else {
            $url = $opportunityContainer->generateObjectUrl('edit', $entity);
            $name = '<a href="'.$url.'">'.$entity->getName().'</a>';
            $this->addFlash('sonata_flash_error', sprintf('Cannot close a lead - it was already closed before. "%s"', $name));
        }
        
        return new RedirectResponse($this->admin->generateUrl('list'));
    }
    
    public function cancelAction()
    {
        $lead = $this->lookupLead();

        if ($lead->getStatus() === DealStatus::PENDING) {
            $leadRepository = $this->getRepository();
            $leadRepository->cancelLead($lead);

            $event = new CustomEvent();
            $event->setLead($lead);
            $dispatcher = $this->container->get('event_dispatcher');
            $dispatcher->dispatch('regeneration.setToLead',$event);
            $this->addFlash('sonata_flash_success', sprintf('Lead "%s" was cancelled.', $lead->getName()));
            if($event->getRedirectUrl()) {
                return new RedirectResponse($event->getRedirectUrl());
            }

        } else {
            $this->addFlash('sonata_flash_error', 'Cannot cancel a lead - it was already closed before.');
        }
        
        return new RedirectResponse($this->admin->generateUrl('list'));
    }
    
    public function reopenAction() {
        $lead = $this->lookupLead();
        
        if ($lead->getStatus() !== DealStatus::PENDING) {
            $leadRepository = $this->getRepository();
            $leadRepository->reopenLead($lead);
            $this->addFlash('sonata_flash_success', sprintf('Lead "%s" was reopened.', $lead->getName()));
        } else {
            $this->addFlash('sonata_flash_error', 'Cannot reopen a lead - it is already open.');
        }
        
        return new RedirectResponse($this->admin->generateUrl('list'));
    }
    
    public function warmupAction() {
        $lead = $this->lookupLead();
        
        if ($lead->getStatus() === DealStatus::PENDING) {
            if ($lead->getType() !== LeadType::WARM) {
                $leadRepository = $this->getRepository();
                $leadRepository->warmupLead($lead);
                $this->addFlash('sonata_flash_success', sprintf('Lead "%s" was switched into Warm type.', $lead->getName()));
            } else {
                $this->addFlash('sonata_flash_error', 'Cannot warm up a lead - it is already warm.');
            }
        } else {
            $this->addFlash('sonata_flash_error', 'Cannot warm up a lead - it is closed.');
        }
        
        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    public function updateAction($lead= null)
    {
        $leadScoring = $this->container->get('sonata.admin.pool')->getAdminByAdminCode('zeshar_crm_lead_scoring.admin.lead_scoring');
        $url = $leadScoring->generateUrl('scoring',array('lead'=>$lead));
        return new RedirectResponse($url);
    }


    private function lookupLead()
    {
        $id = $this->get('request')->get($this->admin->getIdParameter());
        
        $lead = $this->admin->getObject($id);
        
        if (!$lead) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }
        
        return $lead;
    }

    private function getRepository()
    {
        return $this->getDoctrine()->getRepository('ZesharCRM\Bundle\CoreBundle\Entity\Lead');
    }

    public function listAction()
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        $datagrid = $this->admin->getDatagrid();
        $formView = $datagrid->getForm()->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

        $activityTitle = $activityName = null;
        if (isset($_GET['activityId'])) {
            $activityId = $_GET['activityId'];
            $em = $this->getDoctrine()->getManager();
            $activity = $em->getRepository('ZesharCRMCoreBundle:Activity')->findOneBy(array('id' => $activityId));
            $activityTitle = $activityName = $activity->getTitle();
            $activityTitle = "SurgeActivity - " . $activityTitle;
        }

        return $this->render($this->admin->getTemplate('list'), array(
            'action'     => 'list',
            'form'       => $formView,
            'datagrid'   => $datagrid,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
            'pageTitle' =>  $activityTitle ? $activityTitle : '',
            'activityName' =>  $activityName ? $activityName : '',
        ));
    }

    public function listDeletedAction()
    {
//        $em = $this->getDoctrine()->getManager();
//        $em->getRepository('ZesharCRMCoreBundle:LeadSubject')->getRemovedLeads();
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        $datagrid = $this->admin->getDatagrid();
        $formView = $datagrid->getForm()->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

        $activityTitle = $activityName = null;
        if(isset($_GET['activityId'])){
            $activityId = $_GET['activityId'];
            $em = $this->getDoctrine()->getManager();
            $activity = $em->getRepository('ZesharCRMCoreBundle:Activity')->findOneBy(array('id' => $activityId));
            $activityTitle = $activityName = $activity->getTitle();
            $activityTitle = "SurgeActivity - ".$activityTitle;
        }

        return $this->render($this->admin->getTemplate('listDeleted'), array(
            'action'     => 'deletedList',
            'form'       => $formView,
            'datagrid'   => $datagrid,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
            'pageTitle' =>  $activityTitle ? $activityTitle : '',
            'activityName' =>  $activityName ? $activityName : '',
        ));
    }
}