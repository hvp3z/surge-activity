<?php

namespace ZesharCRM\Bundle\CoreBundle\Admin;

use ZesharCRM\Bundle\CoreBundle\Enum\LeadContactStatus;
use ZesharCRM\Bundle\CoreBundle\Form\Type as ZesharCRMCoreType;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class LeadSubjectAdmin extends CLAdmin
{

    public function toString($object)
    {
        if ($object->getContactCard()) {
            return $object->getContactCard()->getFullName();
        } else {
            return 'Lead';
        }
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
            ->add('contactCard.fullName', 'doctrine_orm_callback', array(
                'callback'   => array($this, 'getFullNameFilter'),
                'field_type' => 'text',
                'label' => 'Name',
            ))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('contactCard.fullName', null, array(
                'label' => 'Name',
                'route' => array(
                    'name' => 'show',
                ),
            ))
            ->add('contactCard.phone', null, array(
                'label' => 'Phone',
                'route' => array(
                    'name' => 'show',
                ),
            ))
            ->add('leadCampaign', null, array(
                'label' => 'Activity',
                'route' => array(
                    'name' => 'show',
                ),
                'template' => 'ZesharCRMCoreBundle:ListField:list_field_raw_value.html.twig',
                'admin_code' => 'zeshar_crm_core.admin.activity'
            ))
            ->add('leadCategory', null, array(
                'label' => 'Product',
                'route' => array(
                    'name' => 'show',
                ),
                'template' => 'ZesharCRMCoreBundle:ListField:list_field_raw_value.html.twig',
            ))
            ->add('contactCard.email', null, array(
                'label' => 'Email',
                'route' => array(
                    'name' => 'show',
                ),
                'template' => 'ZesharCRMCoreBundle:ListField:lead_email.html.twig',
            ))
            ->add('leadSource', null, array(
                'label' => 'Source',
                'route' => array(
                    'name' => 'show',
                ),
                'template' => 'ZesharCRMCoreBundle:ListField:list_field_raw_value.html.twig',
            ))
            ->add('createdAt', 'date', array(
                'label' => 'Created',
                'format' => 'M d, Y',
            ))
            ->add('contactCard.callStatus', NULL, array(
                'label' => 'Contact Status',
                'template' => 'ZesharCRMCoreBundle:ListField:contact_status.html.twig',
            ))
            ->add('assignee', null, array(
                'route' => array(
                    'name' => 'show',
                ),
            'template' => 'ZesharCRMCoreBundle:ListField:list_field_raw_value.html.twig',
            ))
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
                $aliasJoin = 'le' . rand() . 'ad';
                $datagrid
                    ->getQuery()
                    ->getQueryBuilder()
                    ->leftJoin("ZesharCRM\Bundle\CoreBundle\Entity\Lead", $aliasJoin, 'WITH', "{$alias}.id = {$aliasJoin}.id")
                    ->andWhere("(IF({$aliasJoin}.assignee != 0, {$aliasJoin}.assignee, {$aliasJoin}.creator) = :user_id)")
                    ->setParameter('user_id', $user->getId())
                ;
            }
        }

        return $this->datagrid;
    }

    public function getFullNameFilter($queryBuilder, $alias, $field, $value)
    {
        if (!$value) {
            return;
        }

        $queryBuilder->leftJoin(sprintf('%s.contactCard', $alias), 'cfn');
        $queryBuilder->andWhere('CONCAT(cfn.firstName, CONCAT(\' \', cfn.lastName)) LIKE :term_fn');
        $queryBuilder->setParameter(':term_fn', '%' . $value['value'] . '%');

        return true;
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
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
        ;
    }
}