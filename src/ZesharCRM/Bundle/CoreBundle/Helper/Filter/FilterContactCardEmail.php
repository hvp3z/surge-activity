<?php

namespace ZesharCRM\Bundle\CoreBundle\Helper\Filter;

use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;

class FilterContactCardEmail extends \Sonata\DoctrineORMAdminBundle\Filter\StringFilter
{
    
    public function filter(ProxyQueryInterface $queryBuilder, $alias, $field, $data)
    {
              
        if (empty($data['value']) || !is_string($data['value'])) {
            return;
        }
     
        $queryBuilder->join('ZesharCRMCoreBundle:Contact', 'ce', \Doctrine\ORM\Query\Expr\Join::WITH, 'ce.contactCard = s_contactCard.id');
        $queryBuilder->andWhere('ce.type = :email_e');
        $queryBuilder->andWhere('ce.value LIKE :value_e');
        // $queryBuilder->andWhere('ce.isDefault = :default_e');
        $queryBuilder->setParameter(':email_e', \ZesharCRM\Bundle\CoreBundle\Enum\ContactType::EMAIL);
        $queryBuilder->setParameter(':value_e', '%' . $data['value'] . '%');
        // $queryBuilder->setParameter(':default_e', 1);
    }
}