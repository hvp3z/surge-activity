<?php

namespace ZesharCRM\Bundle\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class LeadSourceAdmin extends Admin
{

    public function createQuery($context = 'list')
    {
        $user = self::getLoggedInUser();
        $company = $user->getCompany();

        $queryBuilder = $this->getModelManager()->getEntityManager($this->getClass())->createQueryBuilder();

        $queryBuilder
            ->select('l')
            ->from('ZesharCRMCoreBundle:LeadSource', 'l')
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
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('title')
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
            ->add('title')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title')
        ;
    }

    private function getLoggedInUser()
    {
        if ($user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser()) {
            return $user;
        }
        return NULL;
    }
}
