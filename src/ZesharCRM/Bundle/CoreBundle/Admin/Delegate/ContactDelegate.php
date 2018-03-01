<?php

namespace ZesharCRM\Bundle\CoreBundle\Admin\Delegate;

use Sonata\AdminBundle\Admin\Admin;

class ContactDelegate
{
    
    private $adminService;
    
    public function __construct(Admin $adminService)
    {
        $this->adminService = $adminService;
    }
    
    /**
     * 
     * @param Lead|Opportunity $object
     * @param string $name Route name (show, edit, delete etc.)
     * @param array $parameters
     * @param boolean $absolute
     * @throws \BadMethodCallException If given object if neither a Lead nor a Opportunity
     */
    public function generateContactCardObjectUrl($object, $name = 'show', array $parameters = array(), $absolute = false)
    {
        if (!method_exists($object, 'getContactCard')) {
            throw new \BadMethodCallException('$object has no cotact card field');
        }
        
        if ($contactCard = $object->getContactCard()) {
            return $this
                ->adminService
                ->getConfigurationPool()
                ->getContainer()
                ->get('zeshar_crm_core.admin.contact_card')
                ->generateObjectUrl($name, $contactCard, $parameters, $absolute)
            ;
        }
        
        return NULL;
    }
    
}
