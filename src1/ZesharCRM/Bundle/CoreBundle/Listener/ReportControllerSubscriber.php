<?php


namespace ZesharCRM\Bundle\CoreBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use \ZesharCRM\Bundle\CoreBundle\Controller\ReportsController;
use \ZesharCRM\Bundle\GoalsBundle\Controller\GoalGlobalAdminController;

class ReportControllerSubscriber
{

    public function __construct($container){
        $this->container = $container;
    }


    public function onKernelRequest(FilterControllerEvent $event)
    {
        if (!$event->isMasterRequest()) {
            // don't do anything if it's not the master request
            return;
        }

        $controllerSet = $event->getController();
        if(isset($controllerSet[0]) && ($controllerSet[0] instanceof ReportsController || $controllerSet[0] instanceof GoalGlobalAdminController)){
            $em = $this->container->get('doctrine.orm.entity_manager');
            if($from = $event->getRequest()->get('date-range-from')){


                $filter = $em->getFilters()->enable('date_range_filter');
                $filter->setParameter('from', $this->extractDate($from));
            }

            if($to = $event->getRequest()->get('date-range-to')){
                $filter = $em->getFilters()->enable('date_range_filter');
                $filter->setParameter('to', $this->extractDate($to));
            }
        }
    }


    protected function extractDate($string){
        $date = \DateTime::createFromFormat('M d, Y', $string);
        return $date;
    }
}