<?php

namespace ZesharCRM\Bundle\CoreBundle\Helper\Filter;

use ZesharCRM\Bundle\CoreBundle\Enum\ContactType;
use ZesharCRM\Bundle\CoreBundle\Enum\LeadContactStatus;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;

class FilterContactCardCallStatus extends \Sonata\DoctrineORMAdminBundle\Filter\ChoiceFilter
{
    
    public function filter(ProxyQueryInterface $queryBuilder, $alias, $field, $data)
    {
        
        if (empty($data['value']) || !is_numeric($data['value'])) {
            return;
        }
     
        $queryBuilder->leftJoin('ZesharCRMCoreBundle:Contact', 'ccs', \Doctrine\ORM\Query\Expr\Join::WITH, 'ccs.contactCard = s_contactCard.id');

        if ($data['value'] == 2) {
            $queryBuilder->andWhere('ccs.donotCall = :status_cs OR ccs IS NULL OR (ccs.type IN (:phones_cs) AND ccs.donotCall IS NULL AND ccs.isDefault = :default_cs)');
            $queryBuilder->setParameter(':default_cs', 1);
        } else {
            $queryBuilder->andWhere('ccs.type IN (:phones_cs)');
            $queryBuilder->andWhere('ccs.donotCall = :status_cs');
        }

        $queryBuilder->setParameter(':phones_cs', array(ContactType::GENERIC_PHONE, ContactType::CELL_PHONE, ContactType::WORK_PHONE));
        $queryBuilder->setParameter(':status_cs', $data['value']);
    }
    
    public function getRenderSettings()
    {
        return array('sonata_type_filter_default', array(
            'operator_type' => 'sonata_type_equal',
            'field_type'    => 'choice',
            'field_options' => array_merge($this->getFieldOptions(), array(
                'choices' => LeadContactStatus::getHumanTitlesMap(),
            )),
            'label'         => $this->getLabel(),
        ));
    }
}