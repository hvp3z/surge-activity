<?php

namespace ZesharCRM\Bundle\CoreBundle\Helper\Filter;

use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;

class FilterContactCardPhone extends \Sonata\DoctrineORMAdminBundle\Filter\StringFilter
{
    
    public function filter(ProxyQueryInterface $queryBuilder, $alias, $field, $data)
    {
              
        if (empty($data['value']) || !is_string($data['value'])) {
            return;
        }
     
        $queryBuilder->join('ZesharCRMCoreBundle:Contact', 'cp', \Doctrine\ORM\Query\Expr\Join::WITH, 'cp.contactCard = s_contactCard.id');
        $queryBuilder->andWhere('cp.type = :phone_p');
        $queryBuilder->andWhere('cp.value LIKE :value_p');
        // $queryBuilder->andWhere('cp.isDefault = :default_p');
        $queryBuilder->setParameter(':phone_p', \ZesharCRM\Bundle\CoreBundle\Enum\ContactType::GENERIC_PHONE);
        $queryBuilder->setParameter(':value_p', '%' . $data['value'] . '%');
        // $queryBuilder->setParameter(':default_p', 1);
    }
}