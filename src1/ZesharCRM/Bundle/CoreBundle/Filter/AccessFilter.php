<?php

namespace ZesharCRM\Bundle\CoreBundle\Filter;

use Doctrine\ORM\Mapping\ClassMetaData;
use Doctrine\ORM\Query\Filter\SQLFilter;

class AccessFilter extends SQLFilter
{

    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        // Check if the entity implements the right interface
        if ($targetEntity->reflClass->implementsInterface('ZesharCRM\Bundle\CoreBundle\Entity\AccessInterface')) {
            try {
                $this->getParameter('filter');
                $userId = $this->getParameter('user_id');
            } catch (\InvalidArgumentException $e) {
                return "";
            }

            return "(IFNULL({$targetTableAlias}.assignee, {$targetTableAlias}.creator) = {$userId})";
        } else {
            return "";
        }
    }
}