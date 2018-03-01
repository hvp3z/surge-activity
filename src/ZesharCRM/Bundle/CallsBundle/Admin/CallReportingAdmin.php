<?php

namespace ZesharCRM\Bundle\CallsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use ZesharCRM\Bundle\CallsBundle\Enum\CallReportingType;
use ZesharCRM\Bundle\CallsBundle\Enum\CallReportingStatus;
use ZesharCRM\Bundle\CoreBundle\Admin\CLAdmin;
use ZesharCRM\Bundle\CoreBundle\Admin\LeadSubject;
use Sonata\AdminBundle\Route\RouteCollection;
use ZesharCRM\Bundle\CoreBundle\Enum\ContactType;

use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery as ProxyQueryInterface;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class CallReportingAdmin extends CLAdmin
{

    /**
     * define custom variable
     */
    public function initialize()
    {
        if (!$this->classnameLabel) {
            $this->classnameLabel = 'Contact Reporting';
        }

        $this->baseCodeRoute = $this->getCode();

        $this->configure();
    }

    public function createQuery($context = 'list')
    {
        $queryBuilder = $this->getModelManager()->getEntityManager($this->getClass())->createQueryBuilder();

        $user = parent::getLoggedInUser();
        $company = $user->getCompany();

        $queryBuilder
            ->select('l')
            ->from($this->getClass(), 'l')
            ->leftJoin('l.assignee','a')
            ->andWhere('a.company = '.$company->getId())
        ;

        $proxyQuery = new ProxyQuery($queryBuilder);

        return $proxyQuery;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('type', 'doctrine_orm_choice', array(
                'field_type' => 'choice',
                'field_options' => array(
                    'choices' => CallReportingType::getHumanTitlesMap(),
                ),
            ))
            ->add('status', 'doctrine_orm_choice', array(
                'label' => 'Result',
                'field_type' => 'choice',
                'field_options' => array(
                    'choices' => CallReportingStatus::getHumanTitlesMap(),
                ),
            ))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        if (!$this->userIsPrivileged()) {
            $listMapper->add('assignee.username', null, array('label' => 'Sales Person'));
        } else {
            $listMapper->add('assignee', null, array('label' => 'Sales Person'));
        }

        $listMapper
            ->add('lead', null, array(
                'label' => 'Lead'
            ))
            ->add('contact',null,array(
                'template' => 'ZesharCRMCoreBundle:CRUD:list_orm_many_to_one_custom.html.twig'
            ))
            ->add('startsAt', null, array(
                'label' => 'Date'
            ))
            ->add('eventsTypeString', null, array(
                'label' => 'Type',
            ))
            ->add('duration','datetime',array(
                'format' => 'H : i')
            )
            ->add('typeString', null, array(
                'label' => 'Direction',
            ))
            ->add('statusString', null, array(
                'label' => 'Result',
            ))
//            ->add('_action', 'actions', array(
//                'actions' => array(
//                    'show' => array(),
//                    'edit' => array(),
//                    'delete' => array(),
//                ),
//                'template' => 'ZesharCRMCallsBundle:CRUD:list_action_field.html.twig'
//            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getDatagrid()
    {
        $datagrid = parent::getDatagrid();
        
        // security - filter lists
        if (!$this->userIsPrivileged()) {
            if ($user = $this->getLoggedInUser()) {
                $part = $datagrid->getQuery()->getQueryBuilder();
                $alias = $part->getDqlPart('from')[0]->getAlias();
                $datagrid
                    ->getQuery()
                    ->getQueryBuilder()
                    ->andWhere("({$alias}.assignee = :user_id)")
                    ->setParameter('user_id', $user->getId())
                ;
            }
        }

        return $this->datagrid;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('lead', 'sonata_type_model_list', array(
                'label' => 'Lead',
                'btn_delete'    => false,
                'btn_add'    => false,
                'required' => FALSE,
                'by_reference' => FALSE
            ),array(
                'placeholder' => 'No lead selected',
            ))
            ->add('description')
            ->add('contact', 'sonata_type_model_list', array(
                'btn_delete'    => false,
                'required' => FALSE,
                'by_reference' => FALSE
            ),array(
                'placeholder' => 'No contact selected',
            ))
            ->add('startsAt', null, array(
                'data' => new \DateTime("now"),
                'label' => 'Date'
            ))
            ->add('duration')
            ->add('eventsType', 'choice', array(
                'label' => 'Type',
                'choices' => ContactType::getHumanTitlesMap(),
            ))
            ->add('type', 'choice', array(
                'label' => 'Direction',
                'choices' => CallReportingType::getHumanTitlesMap(),
            ))
            ->add('status', 'choice', array(
                'label' => 'Result',
                'choices' => CallReportingStatus::getHumanTitlesMap(),
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
            ->add('subject', null, array(
                'label' => 'Lead'
            ))
            ->add('description')
            ->add('contact')
            ->add('startsAt', null, array(
                'label' => 'Date'
            ))
            ->add('duration','datetime',array(
                    'format' => 'H : i')
            )
            ->add('eventsTypeString', null, array(
                'label' => 'Type',
            ))
            ->add('typeString', null, array(
                'label' => 'Direction',
            ))
            ->add('statusString', null, array(
                'label' => 'Result',
            ))
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('listShow', 'listShow');
    }
}
