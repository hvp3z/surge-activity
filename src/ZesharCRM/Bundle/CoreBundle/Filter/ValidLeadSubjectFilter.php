<?php

namespace ZesharCRM\Bundle\CoreBundle\Filter;

use Doctrine\ORM\Mapping\ClassMetaData;
use Doctrine\ORM\Query\Filter\SQLFilter;

class ValidLeadSubjectFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        // Check if the entity implements the LocalAware interface
        if (!$targetEntity->reflClass->implementsInterface('ZesharCRM\Bundle\CoreBundle\Entity\LeadSubjectInterface')) {
            return "";
        }

        return '((' . $targetTableAlias . '.lead_category IS NOT NULL AND ' . $targetTableAlias . '.discr = "lead") OR '
        . $targetTableAlias . '.created_at <> ' . $targetTableAlias . '.updated_at) OR (' . $targetTableAlias
        . '.discr = "opportunity" AND ' . $targetTableAlias . '.status <> 7 )';
    }
}