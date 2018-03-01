<?php

namespace ZesharCRM\Bundle\CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Sonata\AdminBundle\Admin\Admin as AdminService;

class SonataAdminConfigureEvent extends Event
{

    private $adminService;
    private $methodName;
    private $methodArgs;
    
    public static function getEventId()
    {
        return 'zeshar_crm_core.sonata_admin_configure';
    }
    
    public function __construct(AdminService $adminService, $methodName, array $methodArgs = array()) {
        $this->adminService = $adminService;
        $this->methodName = $methodName;
        $this->methodArgs = $methodArgs;
    }
    
    public function getAdminService() {
        return $this->adminService;
    }

    public function getMethodName() {
        return $this->methodName;
    }

    public function getMethodArgs() {
        return $this->methodArgs;
    }
    
}
