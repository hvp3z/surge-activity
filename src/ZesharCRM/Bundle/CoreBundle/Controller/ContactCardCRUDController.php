<?php

namespace ZesharCRM\Bundle\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use ZesharCRM\Bundle\CoreBundle\Event\CustomEvent;
use ZesharCRM\Bundle\CoreBundle\Enum\OpportunityStatus;
use Sonata\AdminBundle\Controller\CRUDController as CRUDController;

class ContactCardCRUDController extends CRUDController
{

    public function showAction($id = null)
    {
        $id = $this->get('request')->get($this->admin->getIdParameter());

        $object = $this->admin->getObject($id);
       // print_r($object);die;

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        if (false === $this->admin->isGranted('VIEW', $object)) {
            throw new AccessDeniedException();
        }

        $this->admin->setSubject($object);

        $quote = $this->getDoctrine()->getRepository('ZesharCRMCoreBundle:Opportunity')->findBy(array('contactCard' => $object, 'status' => OpportunityStatus::SUCCESS_QUOTE));

        $event = new CustomEvent();
        $dispatcher = $this->container->get('event_dispatcher');
        $dispatcher->dispatch('regeneration.enableModule',$event);
        $crossSell = $event->getEnable();

        return $this->render('ZesharCRMCoreBundle:CRUD:contact_card_show.html.twig', array(
            'action'   => 'show',
            'object'   => $object,
            'elements' => $this->admin->getShow(),
            'quote'    => $quote,
            'crossSell'=> $crossSell,
        ));
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

        return $this->render('ZesharCRMCoreBundle:CRUD:base_list_custom.html.twig', array(
            'action'     => 'list',
            'form'       => $formView,
            'datagrid'   => $datagrid,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
        ));
    }

    public function winBackQuoteAction($id)
    {
        $idObject = $this->get('request')->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($idObject);
        $repository = $this->getDoctrine()->getRepository('ZesharCRMCoreBundle:Opportunity');
        $quote = $repository->findOneById($this->get('request')->get('quote'));
        $repository->winBackQuote($quote);

        $event = new CustomEvent();
        $event->setLead($quote->getLead());
        $dispatcher = $this->container->get('event_dispatcher');
        $dispatcher->dispatch('regeneration.setToProduct',$event);

        if (!$quote) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }
        return new RedirectResponse( $this->admin->generateObjectUrl('show', $object));
    }

}
