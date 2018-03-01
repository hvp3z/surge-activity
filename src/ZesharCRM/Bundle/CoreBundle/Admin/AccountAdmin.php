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



class AccountAdmin extends CLAdmin
{
    protected $baseRouteName = 'account';
    protected $baseRoutePattern = 'account';


    public function getTemplate($name) {

        if ('edit' === $name || 'create' === $name) {
            return 'ZesharCRMCoreBundle:CRUD:admin_account_create.html.twig';
        }elseif('show' === $name){
            return 'ZesharCRMCoreBundle:CRUD:admin_account_edit.html.twig';
        }
        return parent::getTemplate($name);
    }
    
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
