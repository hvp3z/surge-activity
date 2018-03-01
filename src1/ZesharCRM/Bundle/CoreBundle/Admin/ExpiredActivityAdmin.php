<?php

namespace ZesharCRM\Bundle\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class ExpiredActivityAdmin extends ActivityAdmin
{
    protected $baseRouteName = 'admin_expiredactivity';
    protected $baseRoutePattern = 'expiredactivity';

    /**
     * Override to orderby name and date
     *
     * @param string $context
     *
     * @return \Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery
     */
    public function createQuery($context = 'list')
    {
        $date = new \DateTime('today');
        $timestamp = $date->getTimestamp();
        $now = date("Y-m-d H:i:s" , $timestamp);

        $user = parent::getLoggedInUser();
        $company = $user->getCompany();

        $queryBuilder = $this->getModelManager()->getEntityManager($this->getClass())->createQueryBuilder();

        $queryBuilder
            ->select('v')
            ->from('ZesharCRMCoreBundle:Activity', 'v')
            ->andWhere( 'v.finishesAt < :now')
            ->leftJoin('v.creator', 'u')
            ->andWhere('u.company = :company')
            ->setParameters(array('now' => $now, 'company' => $company))
        ;

        $proxyQuery = new ProxyQuery($queryBuilder);

        //print_r($proxyQuery->getQuery()->getSQL()); die;

        return $proxyQuery;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title', 'url', array(
                'label' => 'Activity Type',
                'route' => array(
                    'name' => 'admin_zesharcrm_core_lead_list',
                    'identifier_parameter_name' => 'filter[leadCampaign][value]',
                    'parameters' => array('filters' => 'reset'),
                )
            ));

        if (!$this->userIsPrivileged()) {
            $listMapper
                ->add('assignee.username', null, array(
                    'label' => 'Assignee'
                ));
        } else {
            $listMapper
                ->add('assignee', null, array(
                    'label' => 'Assignee'
                ));
        }

        $listMapper
            ->add('frequencyString', 'string', array(
                'label' => 'Frequency'
            ))
            ->add('slotString', null, array(
                'label' => 'Slot'
            ))
            ->add('startsAt', 'date', array(
                'label' => 'Start date'
            ))
            ->add('startTime', 'time', array(
                'label' => 'Start time'
            ))
            ->add('endTime', 'time', array(
                'label' => 'End time'
            ))
            ->add('finishesAt', 'date', array(
                'label' => 'End date'
            ))
            ->add('typeString', array(), array(
                'label' => 'Action',
            ))
            ->add('quantity')
            ->add('_action', 'actions', array(
                'label' => ' ',
                'actions' => array(
                    'show' => array(
                        'template' => 'ZesharCRMCoreBundle:ActivityCRUD:list__action_show_activity.html.twig'
                    ),
                    'edit' => array(
                        'template' => 'ZesharCRMCoreBundle:ActivityCRUD:list__action_edit_activity.html.twig'
                    ),
                    'closeActivity' => array(
                        'template' => 'ZesharCRMCoreBundle:ActivityCRUD:list__action_close_activity.html.twig'
                    ),
                )
            ))
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list'));
        $collection->add('closeActivity', $this->getRouterIdParameter() . '/close_activity');
        $collection->add('export');
        $collection->add('batch');
    }
}
