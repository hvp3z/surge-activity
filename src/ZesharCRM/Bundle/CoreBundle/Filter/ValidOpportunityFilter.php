<?php

namespace ZesharCRM\Bundle\CoreBundle\Filter;

use Doctrine\ORM\Mapping\ClassMetaData;
use Doctrine\ORM\Query\Filter\SQLFilter;

class ValidOpportunityFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
{
    return "";
//        if (!$targetEntity->reflClass->implementsInterface('ZesharCRM\Bundle\CoreBundle\Entity\LeadSubjectInterface')) {
//            return "";
//        }
//
//        return '(' . $targetTableAlias . '.discr = "opportunity" AND ' . $targetTableAlias . '.status <> 7 ) OR ' . $targetTableAlias . '.discr = "lead"';
}
}