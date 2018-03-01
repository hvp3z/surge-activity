<?php

namespace ZesharCRM\Bundle\CoreBundle\Admin;

use ZesharCRM\Bundle\CoreBundle\Form\Type as ZesharCRMCoreType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery as ProxyQueryInterface;

use Ddeboer\DataImport\Workflow as ImportWorkflow;
use Ddeboer\DataImport\ValueConverter as ImportValueConverter;

use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;



class PaymentAdmin extends CLAdmin
{
    protected $baseRouteName = 'admin_payment_history';
    protected $baseRoutePattern = 'payment_history';


//    public function getTemplate($name) {

//        if ('edit' === $name) {
//            return 'ZesharCRMCoreBundle:CRUD:lead_opportunity_edit.html.twig';
//        } elseif ('show' === $name) {
//            return 'ZesharCRMCoreBundle:CRUD:billing_info_show.html.twig';
//        } elseif ('list' === $name) {
//            return 'ZesharCRMCoreBundle:CRUD:billing_info_list.html.twig';
//        } elseif ('create' === $name) {
//            return 'ZesharCRMCoreBundle:CRUD:lead_opportunity_create.html.twig';
//        } elseif ('listDeleted' === $name) {
//            return 'ZesharCRMCoreBundle:CRUD:deleted_lead_list.html.twig';
//        }
//        return parent::getTemplate($name);
//    }
    
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
        ;

        parent::configureDatagridFilters($datagridMapper);
    }


    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, array())
            ->add('date', 'date', array(
                'label' => 'Effective date',
                'format' => 'M d, Y',
            ))
        ;

        parent::configureListFields($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('id')
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
        ;
        
        parent::configureShowFields($showMapper);
    }

}
