<?php
namespace ZesharCRM\Bundle\LeadsRegenerationBundle\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ZesharCRM\Bundle\LeadsRegenerationBundle\Entity\LeadsRegeneration;
use ZesharCRM\Bundle\CoreBundle\Event\CustomEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;


class RESubscriber implements EventSubscriberInterface
{
    public $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'regeneration.setToLead'    => 'setRegenerationToLead',
            'regeneration.setToProduct' => 'setRegenerationToProduct',
            'regeneration.enableModule' => 'enableRegenerationModule',
        );
    }

    public function setRegenerationToLead(CustomEvent $event)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $entity = new LeadsRegeneration();
        $entity->setLead($event->getLead());
        $entity->setRegenerationAt(new \DateTime());
        $em->persist($entity);
        $em->flush($entity);
        $leadsRegenerationContainer = $this->container->get('sonata.admin.pool')->getAdminByAdminCode('zeshar_crm_leads_regeneration.admin.leads_regeneration');
        $event->setRedirectUrl($leadsRegenerationContainer->generateObjectUrl('edit', $entity));
    }

    public function setRegenerationToProduct(CustomEvent $event)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $entity = $em->getRepository('ZesharCRMLeadsRegenerationBundle:LeadsRegeneration')->findOneBy(array('lead' => $event->getLead()));
        if (!$entity) {
            $entity = new LeadsRegeneration();
            $entity->setLead($event->getLead());
        }
        $review = $this->container->getParameter('win_back_regeneration_period');
        if($event->getProduct()) {
            if($event->getProduct()->getReview()) {
                $review = $event->getProduct()->getEffectiveDate() - $event->getProduct()->getReview();
            } else {
                $review = $this->container->getParameter('base_regeneration_period');
            }
        }
        $date = (new \DateTime())->modify('+'.$review.' day');
        $entity->setRegenerationAt($date);
        $em->persist($entity);
        $em->flush($entity);
    }

    public function setRegenerationCrossSell(CustomEvent $event)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $leadProduct = $em->getRepository('ZesharCRMCoreBundle:Lead')->findBy(array('contactCard'=> 1));

    }

    public function enableRegenerationModule(CustomEvent $event)
    {
        $event->setEnable(true);
    }

}