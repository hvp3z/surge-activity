<?php

namespace ZesharCRM\Bundle\CoreBundle\Admin;

use ZesharCRM\Bundle\CoreBundle\Enum\LeadContactStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\LeadMailStatus;
use ZesharCRM\Bundle\CoreBundle\Form\Type as ZesharCRMCoreType;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use ZesharCRM\Bundle\CoreBundle\Enum\ContactType;

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Validator\ErrorElement;



class ContactAdmin extends Admin
{   
    
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('type')
            ->add('name')
            ->add('value', null, array(
                'label' => 'Contact Options'
            ))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('typeString', array(), array(
                'label' => 'Type',
            ))
            ->add('name')
            ->add('value', null, array(
                'label' => 'Contact Options'
            ))
            //->add('mailStatus', new ZesharCRMCoreType\SonataExBooleanType())
//            ->add('callStatus', 'choice', array(
//                'label' => 'Contact Status',
//                'choices' => LeadContactStatus::getHumanTitlesMap(),
//            ))
            ->add('donotCall', NULL, array(
                'label' => 'Contact Status',
            ))
            ->add('dnc', NULL, array(
                'label' => 'DNC',
            ))
            ->add('donotEmail', NULL, array(
                'label' => 'DNE',
            ))
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
            ->add('type', 'choice', array(
                'choices' => ContactType::getHumanTitlesMap(),
            ))
            ->add('donotCall', 'choice', array(
                'label' => 'Contact Status',
                'choices' => LeadContactStatus::getHumanTitlesMap(),
                'required' => FALSE,
            ))

            ->add('dnc', 'choice', array(
                'label' => 'DNC',
                'choices' => LeadMailStatus::getHumanTitlesMap(),
                'required' => FALSE,
            ))
            ->add('donotEmail', 'choice', array(
                'label' => 'DNE',
                'choices' => LeadMailStatus::getHumanTitlesMap(),
                'required' => FALSE,
            ))
//            ->add('dnc', 'collection', array(
//                'type' => new ZesharCRMCoreType\SonataExBooleanType(),
//                'required' => false,
//                'label' => 'DNC',
//            ))
//            ->add('donotEmail', 'collection', array(
//                'type' => new ZesharCRMCoreType\SonataExBooleanType(),
//                'required' => false,
//                'label' => 'DNE',
//            ))

            ->add('isDefault', 'checkbox', array(
                'required' => FALSE,
            ))
            ->add('name', null, array(
                'label' => 'Name'
            ))
            ->add('value', null, array(
                'label' => 'Contact Options'
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
            ->add('id')
            ->add('type')
            ->add('name')
            ->add('value', null, array(
                'label' => 'Contact Options'
            ))
            ->add('donotCall', NULL, array(
                'label' => 'Contact Status',
            ))
            ->add('dnc', NULL, array(
                'label' => 'DNC',
            ))
            ->add('donotEmail', NULL, array(
                'label' => 'DNE',
            ))
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('value')
            ->assertLength(array('max' => 25))
            ->end()
        ;
    }


    
}
