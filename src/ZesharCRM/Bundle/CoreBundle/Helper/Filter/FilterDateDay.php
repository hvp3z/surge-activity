<?php

namespace ZesharCRM\Bundle\CoreBundle\Helper\Filter;

use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;

class FilterDateDay extends \Sonata\DoctrineORMAdminBundle\Filter\AbstractDateFilter
{
    
    protected $range = true;
    
    public function filter(ProxyQueryInterface $queryBuilder, $alias, $field, $data)
    {
        
        if (empty($data['value']) || !$data['value'] instanceof \DateTime) {
            return;
        }
     
        $date = $data['value'];
        $data['value'] = array();
        $data['value']['start'] = $date;
        $data['value']['end'] = date_add(clone $data['value']['start'], \DateInterval::createFromDateString('1 day'));
        
        parent::filter($queryBuilder, $alias, $field, $data);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getRenderSettings()
    {
        $name = 'sonata_type_filter_date';

        if ($this->time) {
            $name .= 'time';
        }

        return array($name, array(
            'field_type'    => $this->getFieldType(),
            'field_options' => $this->getFieldOptions(),
            'label'         => $this->getLabel(),
        ));
    }
}