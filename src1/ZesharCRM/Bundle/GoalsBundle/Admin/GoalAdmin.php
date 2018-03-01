<?php

namespace ZesharCRM\Bundle\GoalsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use ZesharCRM\Bundle\CoreBundle\Enum\GoalKind;
use Sonata\AdminBundle\Route\RouteCollection;
use ZesharCRM\Bundle\CoreBundle\Admin\CLAdmin;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class GoalAdmin extends CLAdmin
{
    public function createQuery($context = 'list')
    {
        $user = parent::getLoggedInUser();
        $company = $user->getCompany();

        $queryBuilder = $this->getModelManager()->getEntityManager($this->getClass())->createQueryBuilder();

        $queryBuilder
            ->select('v')
            ->from('ZesharCRMCoreBundle:LeadCategory', 'l')
            ->leftJoin('v.creator', 'u')
            ->andWhere('u.company = :company')
            ->setParameters(array('company' => $company))
        ;

        $proxyQuery = new ProxyQuery($queryBuilder);

        //print_r($proxyQuery->getQuery()->getSQL()); die;

        return $proxyQuery;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list'));
        $collection->add('list', '../../../goals');
    }
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('startsAt', 'doctrine_orm_date')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('description', null, array('label' => 'Title'))
            ->add('startsAt','date',array(
                'format' => 'Y, M',
            ))
            ->add('finishesAt','date',array(
                'format' => 'Y, M',
            ))
            ->add('goalCategory')
            ->add('estimated', null, array(
                'label'=>'Growth Desired (%)'
            ))
            ->add('total', null, array(
                'label' => 'Sales in the previous year'
            ))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $subject = $this->getSubject();

        $formMapper
            ->add('description', null, array('label' => 'Title'));
        if (!$subject->getEstimated()) {
            $formMapper
                ->add('goalCategory', null, array(
                    'required' => true
                ))
                ->add('estimated',null,array('label' => 'Growth Desired (%)', 'attr' => array('min' => 1, 'max' => 100)))
                ->add('year-goal','choice',array(
                    'choices' => array(date(date('Y')) => 'this-year', date(date('Y')+1) => 'next-year'),
                    'mapped'  => false,
                ))
                ->add('countPrevYear','integer',array(
                    'label' => 'Sales in the previous year',
                    'required' => false,
                    'attr' => array('min' => 1),
                    'mapped'  => false,
                ));
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('description', null, array('label' => 'Title'))
            ->add('startsAt','date',array(
                'format' => 'Y, M',
            ))
            ->add('finishesAt','date',array(
                'format' => 'Y, M',
            ))
            ->add('goalCategory')
            ->add('estimated', null, array(
                'label'=>'Growth Desired (%)'
            ))
            ->add('total', null, array(
                'label' => 'Sales in the previous year'
            ))
        ;
    }
}