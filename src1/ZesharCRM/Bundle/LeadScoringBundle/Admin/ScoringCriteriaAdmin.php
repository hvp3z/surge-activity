<?php

namespace ZesharCRM\Bundle\LeadScoringBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use ZesharCRM\Bundle\CoreBundle\Admin\CLAdmin;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class ScoringCriteriaAdmin extends CLAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('parent')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name')
            ->add('parent')
            ->add('score')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('parent')
            ->add('score',null,array('label' => 'Score (%)', 'attr' => array('min' => 1, 'max' => 100)))
        ;
        parent::configureFormFields($formMapper);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('parent')
            ->add('score')
        ;
    }

    public function createQuery($context = 'list')
    {
        $queryBuilder = $this->getModelManager()->getEntityManager($this->getClass())->createQueryBuilder();

        $user = parent::getLoggedInUser();
        $company = $user->getCompany();

        $queryBuilder
            ->select('o')
            ->from($this->getClass(), 'o')
            ->andWhere('o.company = :company')
            ->setParameter('company', $company)
            ;

        $proxyQuery = new ProxyQuery($queryBuilder);

        return $proxyQuery;
    }
}
