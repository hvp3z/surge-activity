<?php

namespace ZesharCRM\Bundle\GoalsBundle\EventListener;

use ZesharCRM\Bundle\CoreBundle\Event\ConfigureMenuEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ConfigureMenuListener
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    /**
     * @param \ZesharCRM\Bundle\CoreBundle\Event\ConfigureMenuEvent; $event
     */
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();

        $menuBuilder = $this->container->get('zeshar_crm_core.menu_builder');
        $menu = $event->getMenu();
        $reports = $menu->getChild('Reports');

       // $item = $reports->addChild('Goals');
       // $entityAdmin = $this->container->get('zeshar_crm_goals.admin.goal_assignment');
       //$item->addChild('View Goals', array('uri' => $entityAdmin->generateUrl('showUserGoal')))->setLinkAttribute('class', 'icon-link icon-2');

        if ($this->container->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            $adminPanel = $menu->getChild('Admin');
            // $adminPanel->addChild('Goals', array('route' => 'zeshar_crm_goals_users'))->setLinkAttribute('class', 'icon-link icon-2');
            // $reports = $menu->getChild('Reports');
            // $reports->addChild(' Sales Performance', array('route' => 'zeshar_crm_goal_report'));
        }
    }
}
