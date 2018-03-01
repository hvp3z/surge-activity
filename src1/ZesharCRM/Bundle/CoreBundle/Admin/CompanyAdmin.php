<?php

namespace ZesharCRM\Bundle\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use ZesharCRM\Bundle\CoreBundle\Enum\ActivityType;
use ZesharCRM\Bundle\CoreBundle\Enum\ActivityFrequency;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\AdminBundle\Validator\ErrorElement;


class CompanyAdmin extends CLAdmin
{
    protected $baseRouteName = 'admin_company';
    protected $baseRoutePattern = 'company';


    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, $class, $baseControllerName);
    }

    public function createQuery($context = 'list')
    {
        $user = parent::getLoggedInUser();
        $queryBuilder = $this->getModelManager()->getEntityManager($this->getClass())->createQueryBuilder();
        $queryBuilder = $queryBuilder
            ->select('l')
            ->from('ZesharCRMCoreBundle:Company', 'l');
        if (!in_array('ROLE_ULTRA_ADMIN', $user->getRoles())) {
            $queryBuilder
                ->leftJoin('l.users', 'u')
                ->andWhere('u.id = :userId')
                ->setParameter('userId', $user->getId());
        }

        $proxyQuery = new ProxyQuery($queryBuilder);

        return $proxyQuery;
    }



    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', 'string', array(
                'label' => 'Company ID'
            ))
            ->add('name', 'string', array(
                'label' => 'Name',
                'template' => 'ZesharCRMCoreBundle:ListField:company_name_score.html.twig'
            ))
            ->add('firstAddress', null, array(
                'label' => 'Address 1'
            ))
            ->add('secondAddress', null, array(
                'label' => 'Address 2'
            ))
            ->add('city', null, array(
                'label' => 'City'
            ))
            ->add('state', null, array(
                'label' => 'State'
            ))
            ->add('postalCode', null, array(
                'label' => 'Postal Code'
            ))
            ->add('phoneNumber', null, array(
                'label' => 'Phone',
            ))
            ->add('billingStatus', null, array(
                'label' => 'Status',
                'template' => 'ZesharCRMCoreBundle:ListField:billing_status.html.twig',
            ))
            ->add('_action', 'actions', array(
                'label' => ' ',
                'actions' => array(
                    'delete' => array()
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
            ->add('name', null, array(
                'label' => 'Name'
            ))
            ->add('firstAddress', null, array(
                'label' => 'Address 1'
            ))
            ->add('secondAddress', null, array(
                'label' => 'Address 2'
            ))
            ->add('city', null, array(
                'label' => 'City'
            ))
            ->add('state', null, array(
                'label' => 'State'
            ))
            ->add('postalCode', null, array(
                'label' => 'Postal Code'
            ))
            ->add('phoneNumber', null, array(
                'label' => 'Phone',
            ))
        ;
        
        parent::configureFormFields($formMapper);
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
    }


    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name', null, array(
                'label' => 'Name'
            ))
        ;
    }

}