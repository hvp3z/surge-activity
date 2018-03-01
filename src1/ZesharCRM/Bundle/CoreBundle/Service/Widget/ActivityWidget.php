<?php

namespace ZesharCRM\Bundle\CoreBundle\Service\Widget;

use Symfony\Component\DependencyInjection\ContainerInterface;

class ActivityWidget
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function render($user,$persons)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $calendarData = $em->getRepository('ZesharCRMCoreBundle:Activity')->getUserCalendarData($user);
        foreach ($calendarData as &$calendarGroup) {
            foreach ($calendarGroup as &$calendarDay)
                if (!isset($calendarDay['activity'])) {
                    $calendarDay = $this->addIdToEvent($calendarDay);
                }
        }

        return $this->container->get('templating')->render('ZesharCRMCoreBundle:Widget:activity.html.twig', array('calendarData' => $calendarData, 'persons' => $persons, 'selectedUser' => $user->getUsername()));
    }

    private function getNewEventsArray($events)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');

        if($events){
            for($i = 0; $i < count($events); $i++){
                $leadId = $events[$i]['lead'];
                $events[$i]['url'] = 'admin_zesharcrm_core_lead_show';
                $lead = $em->getRepository('ZesharCRMCoreBundle:LeadSubject')->findOneBy(array('id' => $leadId));
                if ($lead instanceof Opportunity) {
                    $lead = $lead->getLead();
                    $leadId = $lead->getId();
                    $events[$i]['url'] = 'admin_zesharcrm_core_opportunity_show';
                }elseif($lead->getIsArchive()){
                    $opportunity = $em->getRepository('ZesharCRMCoreBundle:Opportunity')->findOneBy(array('lead' => $leadId));
                    if($opportunity){
                        $leadId = $opportunity->getId();
                        $events[$i]['url'] = 'admin_zesharcrm_core_opportunity_show';
                    }
                }
                $events[$i]['lead'] = $leadId;
            }
        }
        return $events;
    }

    private function addIdToEvent($calendarDay) {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $leadId = $calendarDay['lead'];
        $calendarDay['url'] = 'admin_zesharcrm_core_lead_show';
        $lead = $em->getRepository('ZesharCRMCoreBundle:LeadSubject')->findOneBy(array('id' => $leadId));
        if ($lead instanceof Opportunity) {
            $lead = $lead->getLead();
            $leadId = $lead->getId();
            $calendarDay['url'] = 'admin_zesharcrm_core_opportunity_show';
        }elseif($lead->getIsArchive()){
            $opportunity = $em->getRepository('ZesharCRMCoreBundle:Opportunity')->findOneBy(array('lead' => $leadId));
            if($opportunity){
                $leadId = $opportunity->getId();
                $calendarDay['url'] = 'admin_zesharcrm_core_opportunity_show';
            }
        }
        $calendarDay['lead'] = $leadId;
        return $calendarDay;
    }

}
