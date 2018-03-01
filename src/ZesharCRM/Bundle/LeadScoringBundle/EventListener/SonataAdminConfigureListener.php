<?php

namespace ZesharCRM\Bundle\LeadScoringBundle\EventListener;

use ZesharCRM\Bundle\CoreBundle\Event\SonataAdminConfigureEvent;
use ZesharCRM\Bundle\CoreBundle\Entity\Lead;
use ZesharCRM\Bundle\LeadScoringBundle\FieldDescription\LeadScoringTotalFieldDescription;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SonataAdminConfigureListener
{
    
    private $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function onSonataAdminConfigure(SonataAdminConfigureEvent $event)
    {
        $adminService = $event->getAdminService();
        $methodName = $event->getMethodName();
        $methodArgs = $event->getMethodArgs();
        
        if ($adminService instanceof \ZesharCRM\Bundle\CoreBundle\Admin\LeadAdmin) {
            $this->configureLeadAdmin($methodName, $methodArgs);
        }
    }
    
    private function configureLeadAdmin($methodName, array $methodArgs = array())
    {
        if ('configureListFields' === $methodName) {
            $listMapper = $methodArgs[0];
            if ($listMapper->has('_action')) {
                $action = $listMapper->get('_action');
                $listMapper->remove('_action');
            }
            $listMapper->add(new LeadScoringTotalFieldDescription(), NULL, array(
                'label' => 'Lead Score',
            ));
            if (isset($action)) {
                $listMapper->add($action);
            }
        } elseif ('configureShowFields' === $methodName) {
            $showMapper = $methodArgs[0];
            $showMapper->add(new LeadScoringTotalFieldDescription(), NULL, array(
                'label' => 'Lead Score',
            ));
        } elseif ('configureDatagridFilters' === $methodName) {
            $datagridMapper = $methodArgs[0];
            $datagridMapper->add('leadScoringTotal', 'zeshar_lead_score');
        }
    }
    
}
