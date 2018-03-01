<?php

namespace ZesharCRM\Bundle\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Validator\Tests\Fixtures\Entity;
use ZesharCRM\Bundle\CoreBundle\Enum\OpportunityPriority;
use ZesharCRM\Bundle\CoreBundle\Enum\OpportunityStatus;
use Sonata\AdminBundle\Validator\ErrorElement;
use ZesharCRM\Bundle\CoreBundle\Form\Type as ZesharCRMCoreType;
use ZesharCRM\Bundle\CoreBundle\Enum\LeadType;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use ZesharCRM\Bundle\CoreBundle\ZesharCRMCoreBundle;
use FOS\UserBundle\Entity\User;
use ZesharCRM\Bundle\CoreBundle\Form\Type\OpportunityUserType;



class OpportunityAdmin extends CLAdmin
{

    private $contactDelegate;

    public function getTemplate($name) {
        if ('edit' === $name) {
            return 'ZesharCRMCoreBundle:CRUD:lead_opportunity_edit.html.twig';
        } elseif ('show' === $name) {
            return 'ZesharCRMCoreBundle:CRUD:lead_opportunity_show.html.twig';
        } elseif ('list' === $name) {
            return 'ZesharCRMCoreBundle:CRUD:lead_opportunity_list.html.twig';
        }
        return parent::getTemplate($name);
    }

    public function __construct($code, $class, $baseControllerName) {
        parent::__construct($code, $class, $baseControllerName);

        $this->contactDelegate = new \ZesharCRM\Bundle\CoreBundle\Admin\Delegate\ContactDelegate($this);
    }

//    protected $datagridValues = array (
//        'status' => array(
//            'value' => OpportunityStatus::PENDING_OPPORTUNITY,
//        )
//    );

    public function createQuery($context = 'list')
    {
        $queryBuilder = $this->getModelManager()->getEntityManager($this->getClass())->createQueryBuilder();
        $user = parent::getLoggedInUser();
        $roles = $user->getRoles();
        $company = $user->getCompany();

        $queryBuilder
            ->select('o')
            ->from($this->getClass(), 'o')
            ->andwhere('o.deletedAt IS NULL')
            ->andwhere('o.isArchive != 1')
            ->orWhere('o.isArchive IS NULL')
        ;

        if(!in_array('ROLE_SUPER_ADMIN', $roles)){
            $queryBuilder->andWhere('o.assignee = '.$user->getId());
        }

        $queryBuilder
            ->leftJoin('o.creator','u')
            ->andWhere('u.company = '.$company->getId())
        ;

        $proxyQuery = new ProxyQuery($queryBuilder);

        return $proxyQuery;
    }

    public function getContactDelegate()
    {
        return $this->contactDelegate;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('contactCard.firstName', NULL, array(
                'label' => 'First Name',
            ))
            ->add('contactCard.middleInitial', NULL, array(
                'label' => 'Middle Initial',
            ))
            ->add('contactCard.phone', 'zeshar_contactcard_phone')
            ->add('lead.type', 'doctrine_orm_choice', array(
                'field_type' => 'choice',
                'field_options' => array(
                    'choices' => LeadType::getHumanTitlesMap(),
                ),
            ))
            ->add('contactCard.lastName', NULL, array(
                'label' => 'Last Name',
            ))
            ->add('status', 'doctrine_orm_choice', array(
                'field_type' => 'choice',
                'field_options' => array(
                    'choices' => OpportunityStatus::getHumanTitlesMap(),
                    'label' => 'Sales Status'
                ),
            ))
            ->add('priority', 'doctrine_orm_choice', array(
                'field_type' => 'choice',
                'field_options' => array(
                    'choices' => OpportunityPriority::getHumanTitles(),
                ),
            ))
            ->add('contactCard.contacts.value',array(), array('label' => 'Contacts',))
            ->add('leadCategory')
            ->add('purchasedAt', 'doctrine_orm_date')
            ->add('closingDate', 'doctrine_orm_date')
            ->add('purchaseAmount')
            ->add('estimatedValue')
            ->add('creator')
            ->add('assignee')
            ->add('createdAt', 'doctrine_orm_date')
            ->add('updatedAt', 'doctrine_orm_date')
            ->add('contactCard.fullName', 'doctrine_orm_callback', array(
                'callback'   => array($this, 'getFullNameFilter'),
                'field_type' => 'text'
            ))
        ;
        
        parent::configureDatagridFilters($datagridMapper);
    }

    public function getFullNameFilter($queryBuilder, $alias, $field, $value)
    {
        if (!$value) {
            return;
        }

        $queryBuilder->leftJoin(sprintf('%s.contactCard', $alias), 'c');
        $queryBuilder->andWhere('CONCAT(c.firstName, CONCAT(\' \', c.lastName)) LIKE :term');
        $queryBuilder->setParameter(':term', '%' . $value['value'] . '%');

        return true;
    }

//    public function getName($queryBuilder, $alias, $field, $value) {
//        if (!$value['value']) {
//            return;
//        }
//
//        $exp = new \Doctrine\ORM\Query\Expr();
//        $queryBuilder->andWhere($exp->like($exp->concat($alias.'.firstName', $alias.'.lastName'), $exp->literal('%' . $value['value'] . '%')));
////        $queryBuilder->andWhere($$exp->concat($alias.'.firstName', $alias.'.lastName'));
//
//        return true;
//    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $bundles = $this->getConfigurationPool()->getContainer()->getParameter('kernel.bundles');
        $listMapper/*
            ->addIdentifier('id')*/
            ->add('contactCard.id', NULL, array(
                'label' => 'Card Id',
                'route' => array(
                    'name' => 'show',
                ),
            ))
           // ->addIdentifier('name')
           ->addIdentifier('contactCard.fullName', null, array(
               'label' => 'Name',
               'route' => array(
                   'name' => 'show',
               ),
           ))

            ->add('contactCard.phone', null, array(
                'label' => 'Phone',
                'template' => 'ZesharCRMCoreBundle:ListField:lead_phone.html.twig',
                'route' => array(
                    'name' => 'show',
                ),
            ))

            ->add('leadCampaign', NULL, array(
                'label' => 'Activity',
                'sortable' => true,
                'sort_field_mapping'=> array('fieldName'=>'title'),
                'sort_parent_association_mappings' => array(array('fieldName'=>'leadCampaign')),
                'admin_code' => 'zeshar_crm_core.admin.activity'
            ))

            ->add('leadCategory', 'string', array(
                'label' => 'Product',
                'sortable' => true,
                'sort_field_mapping'=> array('fieldName'=>'title'),
                'sort_parent_association_mappings' => array(array('fieldName'=>'leadCategory')),
                'route' => array(
                    'name' => 'show',
                ),
            ))
            ->add('quantity', 'string', array(
                'label' => 'Qty',
            ))

            ->add('priority', 'string', array(
                'label' => 'Priority',
                'template' => 'ZesharCRMCoreBundle:ListField:opportunity_lead_priority.html.twig',
            ));

        if (isset($bundles['ZesharCRMLeadScoringBundle'])) {
            $listMapper->add('scoring.total', 'string', array(
                'label' => 'Score',
                'template' => 'ZesharCRMCoreBundle:ListField:opportunity_lead_score.html.twig',
                'route' => array(
                    'name' => 'show',
                ),
            ));
        }

        $listMapper ->add('closingDate', 'date', array(
                'format' => 'M d, Y',
            ))
            ->add('lead.type', null, array(
                'label' => 'Lead Status',
                'template' => 'ZesharCRMCoreBundle:ListField:opportunity_lead_type.html.twig',
            ))

            ->add('statusString', array(), array('label' => 'Sales Status'))
            ->add('assignee', null, array(
                'route' => array(
                    'name' => 'show',
                ),
            ))
            ->add('contactCard.email', NULL, array(
                'label' => 'Email',
                'route' => array(
                    'name' => 'show',
                ),
                'template' => 'ZesharCRMCoreBundle:ListField:lead_email.html.twig',
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('leadCategory', 'sonata_type_model', array(
                'label' => 'Product',
                'required' => TRUE,
            ))
              ->add('contactCard', 'sonata_type_model_list', array(
                  'btn_delete'    => false,
                  'required' => FALSE,
                  'by_reference' => FALSE,
                  'attr' => array(
                    'class' => 'contactCardEntryPoint'
                  ),
                ),array(
                  'placeholder' => 'No contact card selected',
                  'class' => 'contactCardEntryPoint'
                ))
            ->add('purchasedAt', 'date', array(
                'required' => FALSE,
            ))
            ->add('purchaseAmount')
            ->add('estimatedValue')
            //->add('assignee', 'sonata_type_model')
        ;
        $assignees = array(
            'by_reference' => true,
            'cascade_validation' => true,
            'btn_add'    => 'Add new',
            'btn_delete' => 'Delete',
            'required' => true,
            'label' => 'Assignee',
        );

        $user = parent::getLoggedInUser();
        $company = $user->getCompany();
        $assignees['query'] = $this->getModelManager()->getEntityManager($this->getClass())->createQueryBuilder()
            ->select('u')
            ->from('ZesharCRMCoreBundle:User', 'u')
            ->where('u.company = :companyId')
            ->setParameter('companyId', $company->getId())
            ->getQuery();


        $formMapper->add('assignee', 'sonata_type_model', $assignees);

        $formMapper
            ->add('status', 'choice',array(
                'choices' => OpportunityStatus::getHumanTitlesMap(),
                'label' => 'Sales Status'))
            ->add('newAttachment', 'textarea', array(
                'required' => FALSE,
                'label' => 'Add Comment',
            ))
//            ->add('newAttachmentFile', 'file', array(
//                'required' => false,
//                'data_class' => NULL,
//                'label' => 'Add File',
//            ))
//            ->add('attachments', 'sonata_type_collection', array(
//                'required' => TRUE,
//                'by_reference' => TRUE,
//                'required' => FALSE,
//            ), array(
//                'edit' => 'inline',
//                'inline' => 'table',
//            ))
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
            ->add('name')
            ->add('contactCard.firstName', NULL, array(
                'label' => 'First Name',
            ))
            ->add('contactCard.middleInitial', NULL, array(
                'label' => 'Middle Initial',
            ))
            ->add('contactCard.lastName', NULL, array(
                'label' => 'Last Name',
            ))
            ->add('lead', null, array(
                'route' => array(
                    'name' => 'show',
                ),
            ))
//            ->add('statusString', array(), array('label' => 'Status',))
            ->add('contactCard.phone', null, array(
                'label' => 'Phone',
                'route' => array(
                    'name' => 'show',
                ),
            ))
            ->add('leadCategory', null, array(
                'label' => 'Product',
                'route' => array(
                    'name' => 'show',
                ),
            ))
            ->add('purchasedAt', 'date')
            ->add('purchaseAmount')
            ->add('estimatedValue')
            ->add('creator', null, array(
                'route' => array(
                    'name' => 'show',
                ),
            ))
            ->add('assignee', null, array(
                'route' => array(
                    'name' => 'show',
                ),
            ))
            ->add('createdAt')
            ->add('updatedAt')
            ->add('attachments', null, array(
                'template' => 'ZesharCRMCoreBundle:CRUD:show_opportunity_attachments.html.twig',
            ))
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('closeOpportunity', $this->getRouterIdParameter() . '/close_opportunity');
        $collection->add('cancelOpportunity', $this->getRouterIdParameter() . '/cancel_opportunity');
        $collection->add('closeQuote', $this->getRouterIdParameter() . '/close_quote');
        $collection->add('cancelQuote', $this->getRouterIdParameter() . '/cancel_quote');
        $collection->add('update', '{opportunity}/update');
        $collection->add('listQuote', 'listQuote');
        $collection->add('SoldQuote', 'SoldQuote');
        $collection->add('listOpportunity', 'listOpportunity');
        $collection->add('list', 'listOpportunity');
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('contactCard')
            ->assertNotNull()
            ->assertNotBlank()
            ->end()
        ;
    }
    
    /**
     * Hack
     * @param Opportunity $object
     */
    public function bindAttachments($object) {        
        $em = $this->modelManager->getEntityManager('ZesharCRM\Bundle\CoreBundle\Entity\LeadAttachment');
        $attachmentText = $object->getNewAttachment();
        $attachmentFile = $object->getNewAttachmentFile();
        if ( $attachmentText || $attachmentFile ) {
            $attachment = new \ZesharCRM\Bundle\CoreBundle\Entity\Attachment();
            $attachment
                ->setText($attachmentText)
                ->setFile($attachmentFile)
                ->setCreator($object->getCreator())
            ;
            $opportunityAttachment = new \ZesharCRM\Bundle\CoreBundle\Entity\OpportunityAttachment();
            $opportunityAttachment
                ->setAttachment($attachment)
                ->setOpportunity($object)
            ;
            $em->persist($attachment);
            $em->persist($opportunityAttachment);
            $em->flush();
        }
    }
    
    public function postPersist($object) {
        $this->bindAttachments($object);
    }
    
    public function postUpdate($object) {
        $this->bindAttachments($object);
    }
    
}
