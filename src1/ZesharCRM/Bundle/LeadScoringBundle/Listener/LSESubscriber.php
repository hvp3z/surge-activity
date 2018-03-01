<?php
namespace ZesharCRM\Bundle\LeadScoringBundle\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ZesharCRM\Bundle\CoreBundle\Event\ConfigureMenuEvent;


class LSESubscriber implements EventSubscriberInterface
{
    public $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public static function getSubscribedEvents()
    {
        return array(
            ConfigureMenuEvent::getEventId() => 'menuItemAdd',
        );
    }

    public function menuItemAdd(ConfigureMenuEvent $event)
    {
        if ($this->container->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            $menuBuilder = $this->container->get('zeshar_crm_core.menu_builder');
            $menu = $event->getMenu();
            // $setup = $menu->getChild('Admin');
            // $item = $setup->addChild('Lead Scoring');
            // $menuBuilder->buildSimpleSubmenu($item,
            //     'zeshar_crm_lead_scoring.admin.scoring_criteria',
            //     'View Score Criteria',
            //     'Add Score Criteria');
        }
    }

}