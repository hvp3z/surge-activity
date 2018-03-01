<?php
namespace ZesharCRM\Bundle\CallsBundle\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ZesharCRM\Bundle\CoreBundle\Event\CustomEvent;
use ZesharCRM\Bundle\CoreBundle\Event\ConfigureMenuEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;


class CLESubscriber implements EventSubscriberInterface
{
    public $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public static function getSubscribedEvents()
    {
        return array(
//            ConfigureMenuEvent::getEventId() => 'menuItemAdd',
        );
    }

//    public function menuItemAdd(ConfigureMenuEvent $event)
//    {
//        $menuBuilder = $this->container->get('zeshar_crm_core.menu_builder');
//        $menu = $event->getMenu();
//        $reports = $menu->getChild('Reports');
//        $reportAdmin = $this->container->get('zeshar_crm_calls.admin.call_reporting');
//        $item = $reports->addChild('Call Log', array('uri' => $reportAdmin->generateUrl('listShow')))->setLinkAttribute('class', 'icon-link icon-2');
////        $menuBuilder->buildSimpleSubmenu($item,
////            'zeshar_crm_calls.admin.call_reporting',
////            'Call Reporting List',
////            'Log Call');
//    }

}