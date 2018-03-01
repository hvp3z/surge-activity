<?php

namespace ZesharCRM\Bundle\LeadsRegenerationBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use ZesharCRM\Bundle\CoreBundle\Admin\CLAdmin;

class LeadsRegenerationAdmin extends CLAdmin
{
    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('lead')
            ->add('regenerationAt')
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
            ->add('period', 'choice', array(
                'mapped'  => false,
                'required' => false,
                'choices' => array(7 => "week", 1 => "month", 3 => "three month",  6 => "half-year", 12 => "year"),
            ))
            ->add('regenerationAt')
        ;
        parent::configureFormFields($formMapper);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('lead')
            ->add('regenerationAt')
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('edit','list'));

    }
}
