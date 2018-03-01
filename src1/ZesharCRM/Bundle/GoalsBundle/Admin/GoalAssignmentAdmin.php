<?php

namespace ZesharCRM\Bundle\GoalsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use ZesharCRM\Bundle\CoreBundle\Enum\GoalStatus;

class GoalAssignmentAdmin extends Admin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list','show','index','check','edit'));
        $collection->add('check', $this->getRouterIdParameter().'/check');
        $collection->add('showUserGoal', 'showUserGoal');
    }
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('status', 'doctrine_orm_choice', array(
                'field_type' => 'choice',
                'field_options' => array(
                    'choices' => GoalStatus::getHumanTitles(),
                ),
            ))
            ->add('goal')
            ->add('assignee');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('goal')
            ->add('estimated')
            ->add('current')
            ->add('percentComplete')
            ->add('StatusString',array(), array(
                'label' => 'Status'))
            ->add('assignee')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'check' => array(
                        'template' => 'ZesharCRMGoalsBundle:Goal:list_action_check.html.twig'
                    ),
                    'delete' => array(),
                )
            ));
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('goal')
            ->add('goal.Description')
            ->add('estimated')
            ->add('current')
            ->add('percentComplete')
            ->add('status')
            ->add('assignee');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('estimated')
        ;
    }
}
