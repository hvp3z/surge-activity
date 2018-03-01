<?php

namespace ZesharCRM\Bundle\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use ZesharCRM\Bundle\CoreBundle\Enum\OperationType;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class OperationAdmin extends CLAdmin
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
            ->add('performedAt', 'doctrine_orm_datetime_range', array('input_type' => 'timestamp'))
            ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        if (!$this->userIsPrivileged()) {
            $listMapper->add('performer.username', array(), array('label' => 'Sales Person'));
        } else {
            $listMapper->add('performer', array(), array('label' => 'Sales Person'));
        }

        $listMapper
            ->add('typeString', array(), array('label' => 'Operation Type'))
            ->add('entity.contactCard.fullName', null, array(
                'label' => 'Lead',
            ))
            ->add('performedAt')
        ;
    }
}