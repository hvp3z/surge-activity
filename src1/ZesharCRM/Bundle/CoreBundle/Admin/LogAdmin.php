<?php

namespace ZesharCRM\Bundle\CoreBundle\Admin;


use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use ZesharCRM\Bundle\CoreBundle\Enum\LogType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class LogAdmin extends CLAdmin
{

    /**
     * @var array
     */
    public $dateFilter = array(
        'month' => null,
        'year' => null
    );

    /**
     * @var array
     */
    protected $datagridValues = array(
        'status' => array ('type' => 2, 'value' => 0),
        '_page'       => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'performedAt'
    );

    /**
     * Override to orderby name and date
     *
     * @param string $context
     *
     * @return \Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery
     */
    public function createQuery($context = 'list')
    {
        $curMonth = date("m");
        $curYear = date("Y");

        $user = parent::getLoggedInUser();
        $company = $user->getCompany();

        $filters = $this->request->query->get('filter', array());

        if ($this->persistFilters) {
            if (!$filters && $this->request->query->get('filters') != 'reset') {
                $filters = $this->request->getSession()->get($this->getCode().'.filter.parameters', array());
                $this->dateFilter['month'] = $filters ? $filters['performedAt']['value']['date']['month'] : $curMonth;
                $this->dateFilter['year'] = $filters ? $filters['performedAt']['value']['date']['year'] : $curYear;
            }
        }

        $curMonth = $filters ? $filters['performedAt']['value']['date']['month'] : $curMonth;
        $curYear = $filters ? $filters['performedAt']['value']['date']['year'] : $curYear;

        $queryBuilder = $this->getModelManager()->getEntityManager($this->getClass())->createQueryBuilder();
        $queryBuilder
            ->select('op')
            ->from($this->getClass(), 'op')
            ->where('MONTH(op.performedAt) = :curMonth')
            ->andWhere('YEAR(op.performedAt) = :curYear')
            ->leftJoin('op.performer','p')
            ->andWhere('p.company = '.$company->getId())
            ->orderby('op.performedAt','DESC')
            ->setParameter('curMonth', $curMonth)
            ->setParameter('curYear', $curYear);
        $proxyQuery = new ProxyQuery($queryBuilder);
        return $proxyQuery;
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
                    ->andWhere("({$alias}.performer = :user_id)")
                    ->setParameter('user_id', $user->getId())
                ;
            }
        }

        return $this->datagrid;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list'));
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('performedAt')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        if (!$this->userIsPrivileged()) {
            $listMapper->add('performer.username');
        } else {
            $listMapper->add('performer');
        }

        $listMapper
          ->add('operationType', array(), array(
              'label' => 'Operation type',
              'template' => 'ZesharCRMCoreBundle:ListField:log_history_operation_type.html.twig',
          ))
          ->add('performedAt')
        ;
    }


    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('id')
            ->add('performedAt')
            ->add('operationType')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('performedAt')
            ->add('operationType')
        ;
    }
}
