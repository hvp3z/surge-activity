<?php

namespace ZesharCRM\Bundle\CoreBundle\Filter;

use Doctrine\ORM\Mapping\ClassMetaData;
use Doctrine\ORM\Query\Filter\SQLFilter;

class DateRangeFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        // Check if the entity implements the LocalAware interface
        if (!$targetEntity->reflClass->implementsInterface('ZesharCRM\Bundle\CoreBundle\Entity\DateRangeInterface')) {
            return "";
        }

        try {
           $from = $this->getParameter('from');

//           $from = $from->format('Y-m-d H:i:s');
        } catch(\InvalidArgumentException $e){
            $from = null;
        }

        try {
            $to = $this->getParameter('to');
//            $to = $to->format('Y-m-d H:i:s');
        } catch(\InvalidArgumentException $e){
            $to = null;
        }

        $field = $targetEntity->reflClass->getConstant('DATE_FIELD');

        $query = '';
        $clauses = array();
        if($from){
            $clauses[] = $targetTableAlias . '.' . $field . ' >= ' . $from;
        }
        if($to){
            $clauses[] = $targetTableAlias . '.' . $field . ' <= ' . $to;
        }

        $query .= implode(' AND ', $clauses);

        return  $query;
    }
}