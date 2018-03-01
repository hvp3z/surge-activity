<?php

namespace ZesharCRM\Bundle\CoreBundle\Helper\Filter;

use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;

class FilterContactCardFullName extends \Sonata\DoctrineORMAdminBundle\Filter\StringFilter
{
    
    public function filter(ProxyQueryInterface $queryBuilder, $alias, $field, $data)
    {
        
        if (empty($data['value']) || !is_string($data['value'])) {
            return;
        }
     
        $queryBuilder->andWhere('CONCAT(s_contactCard.firstName, :whsp, s_contactCard.middleInitial, :whsp, s_contactCard.lastName) LIKE :fullname OR s_contactCard.firstName LIKE :fullname OR s_contactCard.middleInitial LIKE :fullname OR s_contactCard.lastName LIKE :fullname');
        $queryBuilder->setParameter('fullname', '%' . $data['value'] . '%');
        $queryBuilder->setParameter('whsp', ' ');
    }
}