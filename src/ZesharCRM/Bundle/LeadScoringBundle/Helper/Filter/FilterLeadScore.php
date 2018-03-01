<?php

namespace ZesharCRM\Bundle\LeadScoringBundle\Helper\Filter;

use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;

class FilterLeadScore extends \Sonata\DoctrineORMAdminBundle\Filter\NumberFilter
{
    
    public function filter(ProxyQueryInterface $queryBuilder, $alias, $field, $data)
    {
        if (!isset($data['value']) || !is_numeric($data['value'])) {
            return;
        }

        $queryBuilder->join('ZesharCRMLeadScoringBundle:LeadScoring', 'ls', \Doctrine\ORM\Query\Expr\Join::WITH, 'ls.lead = ' . sprintf('%s.id', $alias));
        $queryBuilder->andWhere('ls.total = :total');
        $queryBuilder->setParameter(':total', $data['value']);
    }
    
    public function getRenderSettings()
    {
        return array('sonata_type_filter_default', array(
            'operator_type' => 'sonata_type_equal',
            'field_type'    => 'number',
            'field_options' => $this->getFieldOptions(),
            'label'         => $this->getLabel(),
        ));
    }
    
}
