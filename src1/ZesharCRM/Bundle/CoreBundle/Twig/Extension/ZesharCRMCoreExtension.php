<?php

namespace ZesharCRM\Bundle\CoreBundle\Twig\Extension;

use ZesharCRM\Bundle\CoreBundle\Entity;

class ZesharCRMCoreExtension extends \Twig_Extension
{
    
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'zeshar_crm_core';
    }
    
    public function getTests ()
    {
        return [
            new \Twig_SimpleTest('lead', function ($entity) { return $entity instanceof Entity\Lead; }),
            new \Twig_SimpleTest('opportunity', function ($entity) { return $entity instanceof Entity\Opportunity; })
        ];
    }

    public function getFilters ()
    {
        return [
            new \Twig_SimpleFilter('lead', array($this, 'checkLeadType')),
            new \Twig_SimpleFilter('opportunity',  array($this, 'checkOpportunityType') ),
            new \Twig_SimpleFilter('checkType',  array($this, 'checkType') ),
        ];
    }

    public function checkLeadType ($entity)
    {
        return $entity instanceof Entity\Lead;
    }

    public function checkOpportunityType ($entity)
    {
        return $entity instanceof Entity\Opportunity;
    }

    public function checkType($entity)
    {
        return get_class($entity) ;
    }
    
}
