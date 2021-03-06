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

class ActivityAdmin extends CLAdmin
{
    protected $baseRouteName = 'admin_activity';
    protected $baseRoutePattern = 'activity';

    public function getTemplate($name) {
        if ('edit' === $name || 'create' === $name) {
            return 'ZesharCRMCoreBundle:CRUD:activity_edit.html.twig';
        }
        if ('list' === $name) {
            return 'ZesharCRMCoreBundle:CRUD:activity_list.html.twig';
        }
        return parent::getTemplate($name);
    }

    public function createQuery($context = 'list')
    {
        $user = parent::getLoggedInUser();
        $company = $user->getCompany();

        $date = new \DateTime('today');
        $timestamp = $date->getTimestamp();
        $now = date("Y-m-d H:i:s" , $timestamp);

        $queryBuilder = $this->getModelManager()->getEntityManager($this->getClass())->createQueryBuilder();

        $queryBuilder
            ->select('v')
            ->from('ZesharCRMCoreBundle:Activity', 'v')
            ->andWhere( 'v.finishesAt >= :now')
            ->leftJoin('v.creator', 'u')
            ->andWhere('u.company = :company')
            ->setParameters(array('now' => $now, 'company' => $company))
        ;

        $proxyQuery = new ProxyQuery($queryBuilder);

        //print_r($proxyQuery->getQuery()->getSQL()); die;

        return $proxyQuery;
    }


    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, $class, $baseControllerName);
    }

    public function filterByPeriod($queryBuilder, $alias, $field, $value)
    {
        if (is_array($value)) {
            $value = isset($value['value']) ? $value['value'] : false;
        }
        if (!$value) {
            return;
        }
        $currentTime = new \DateTime();
        $user = parent::getLoggedInUser();
        $company = $user->getCompany();
        switch ($value){
            case 1:
                $start = $currentTime->format('Y-m-d');
                $end = $currentTime->modify('+1 day')->format('Y-m-d');
                break;
            case 2:
                $start = $currentTime->modify('monday this week')->format('Y-m-d');
                $end = $currentTime->modify('monday next week')->format('Y-m-d');
                break;
            case 3:
                $start = $currentTime->format('Y-m');
                $end = $currentTime->modify('+1 month')->format('Y-m');
                break;
            case 4:
                $start = $currentTime->format('Y');
                $end = $currentTime->modify('+1 year')->format('Y');
                break;

        }
        $queryBuilder->andWhere('('.$alias.'.startsAt >= :start AND '.$alias.'.startsAt< :end ) OR ('.$alias.'.finishesAt >= :start AND '.$alias.'.finishesAt< :end )');
        $queryBuilder->setParameters(array('start' => $start, 'end' => $end, 'now' => $start, 'company' => $company ));
        return true;
    }
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', null, array(
                'label' => 'Activity'
            ))
            ->add('finishesAt', 'doctrine_orm_callback', array(
                'label' => 'Period',
                'callback' => array($this, 'filterByPeriod'),
                'field_type' => 'choice',
                'field_options' => array(
                    'choices' => array(1 => 'day', 2 => 'week', 3 => 'month', 4 => 'year'),
                    'required' => false,
                ),
            ))
            ->add('type', 'doctrine_orm_choice', array(
                'field_type' => 'choice',
                'field_options' => array(
                    'choices' => ActivityType::getHumanTitlesMap(),
                ),
            ))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $object = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager()
            ->getRepository('ZesharCRMCoreBundle:Activity');

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
                    'show' => array(),
                    'edit' => array(),
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
        $user = $this->getLoggedInUser();
        $roles = $user->getRoles();
        if(in_array('ROLE_SUPER_ADMIN', $roles)){
            $formMapper
                ->add('creator', 'sonata_type_model_list', array(
                    'label' => 'Creator',
                    'btn_delete'    => false,
                    'btn_add'    => false,
                    'required' => FALSE,
                    'by_reference' => FALSE

                ),array(
                    'placeholder' => 'No creator selected',
                ))
            ;
        }
        $nowDate = new \DateTime('now');
        $tomorrowDate = $nowDate->modify('+1 day');
        $formMapper
            ->add('title', null, array(
                'label' => 'Activity Type'
            ))
            ->add('startsAt', 'date', array(
                'label' => 'Start date',
                //'data' =>  new \DateTime('now')
            ))
            ->add('finishesAt', 'date', array(
                'label' => 'End date',
                //'data' => $tomorrowDate
            ))
            ->add('frequency', 'choice', array(
                'choices' => ActivityFrequency::getHumanTitlesMap(),
            ))
            ->add('slot', 'datetime', array(
                    'label' => 'Slot',
                )
            )
            ->add('slotString')
            ->add('startTime', 'time', array(
                'label' => 'Start time'
            ))
            ->add('endTime', 'time', array(
                'label' => 'End time'
            ))
            ->add('type', 'choice', array(
                'label' => 'Action ',
                'choices' => ActivityType::getHumanTitlesMap(),
            ))
        ;
        
        parent::configureFormFields($formMapper);
    }

    /**
     * {@inheritdoc}
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('finishesAt')
            ->addConstraint(new \Symfony\Component\Validator\Constraints\GreaterThan($this->getSubject()->getStartsAt()))
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title', null, array(
                'label' => 'Activity'
            ))
            ->add('startsAt')
            ->add('finishesAt')
            ->add('typeString', array(), array(
                'label' => 'Type',
            ))
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('closeActivity', $this->getRouterIdParameter() . '/close_activity');
        $collection->add('listShow', 'listShow');
    }

    public function prePersist($object)
    {
        parent::prePersist($object);
        $formFrequency = $object->getFrequency();
        $formSlot = $object->getSlotString();
        $date = clone $object->getStartsAt();
        if($formFrequency == 2){
            $date->modify('next '.$formSlot);
        }
        $object->setSlot($date);
    }

    public function preUpdate($object)
    {
        parent::preUpdate($object);
        $formFrequency = $object->getFrequency();
        $formSlot = $object->getSlotString();
        $date = clone $object->getStartsAt();
        if($formFrequency == 2){
            $date->modify('next '.$formSlot);
        }
        $object->setSlot($date);
    }
}