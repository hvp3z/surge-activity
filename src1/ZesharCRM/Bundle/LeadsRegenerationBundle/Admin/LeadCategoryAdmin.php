<?php

namespace ZesharCRM\Bundle\LeadsRegenerationBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use ZesharCRM\Bundle\CoreBundle\Admin\CLAdmin;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class LeadCategoryAdmin extends CLAdmin
{
    public $classnameLabel = 'Product';

    public function createQuery($context = 'list')
    {
        $user = parent::getLoggedInUser();
        $company = $user->getCompany();

        $queryBuilder = $this->getModelManager()->getEntityManager($this->getClass())->createQueryBuilder();

        $queryBuilder
            ->select('l')
            ->from('ZesharCRMCoreBundle:LeadCategory', 'l')
            ->leftJoin('l.creator', 'u')
            ->andWhere('u.company = :company')
            ->setParameter('company', $company)
        ;

        $proxyQuery = new ProxyQuery($queryBuilder);

        //print_r($proxyQuery->getQuery()->getSQL()); die;

        return $proxyQuery;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('points')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title')
            ->add('points')
            ->add('effectiveDate', null, array(
                'label' => 'Life Cycle(Days)'
            ))
            ->add('review', null, array(
                'label' => 'Review Days before Term'
            ))
            ->add('_action', 'actions', array(
                'actions' => array(
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
            ->add('title')
            ->add('points',null,array('label' => 'Points', 'attr' => array('min' => 0, 'max' => 1000)))
            ->add('effectiveDate', null, array(
                'label' => 'Life Cycle(Days)'
            ))
            ->add('review', null, array(
                'label' => 'Review Days before Term'
            ))
        ;
        parent::configureFormFields($formMapper);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title')
            ->add('points')
            ->add('effectiveDate', null, array(
                'label' => 'Life Cycle(Days)'
            ))
            ->add('review', null, array(
                'label' => 'Review Days before Term'
            ))
        ;
    }
}