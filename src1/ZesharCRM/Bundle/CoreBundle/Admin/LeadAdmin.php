<?php

namespace ZesharCRM\Bundle\CoreBundle\Admin;

use ZesharCRM\Bundle\CoreBundle\Enum\LeadType;
use ZesharCRM\Bundle\CoreBundle\Enum\DealStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\LeadContactStatus;
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



class LeadAdmin extends CLAdmin
{
    
    private $contactDelegate;

//    protected $datagridValues = array (
//        'isAvailable' => array(
//            'type' => 1,
//            'value' => 0,
//        )
//    );

    public function createQuery($context = 'list')
    {
        $queryBuilder = $this->getModelManager()->getEntityManager($this->getClass())->createQueryBuilder();
        $status = DealStatus::PENDING;
        $currentRoute = $this->getRequest()->get('_route');

        $user = parent::getLoggedInUser();
        $company = $user->getCompany();

        $type = 'lead';
        if (ltrim (strrchr($currentRoute, '_'), '_') == 'listDeleted') {
            $queryBuilder
                ->select('l')
                ->from($this->getClass(), 'l')
                ->where('l.deletedAt IS NOT NULL');
        } else {
            if (isset($_GET['activityId'])) {
                $id = $_GET['activityId'];

                $queryBuilder
                    ->select('l')
                    ->from($this->getClass(), 'l')
                    ->where('l.status = '.$status)
                    ->leftJoin('l.leadCampaign', 'la')
                    ->andWhere('la.id = '.$id)
                    ->andWhere('l.deletedAt IS NULL')
                ;
            } else {
                $queryBuilder
                    ->select('l')
                    ->from($this->getClass(), 'l')
                    ->where('l.status = '.$status)
                    ->andwhere('l.deletedAt IS NULL')
                    ->andwhere('l.isArchive != 1')
                    ->orWhere('l.isArchive IS NULL')
                ;
            }
        }
        $queryBuilder
            ->leftJoin('l.creator','u')
            ->andWhere('u.company = '.$company->getId())
        ;

        $proxyQuery = new ProxyQuery($queryBuilder);
        //print_r($proxyQuery->getQuery()->getSQL()); die;

        return $proxyQuery;
    }

    public function __construct($code, $class, $baseControllerName) {
        parent::__construct($code, $class, $baseControllerName);
        
        $this->contactDelegate = new \ZesharCRM\Bundle\CoreBundle\Admin\Delegate\ContactDelegate($this);
    }
    
    public function getContactDelegate()
    {
        return $this->contactDelegate;
    }
    
    public function getTemplate($name) {

        if ('edit' === $name) {
            return 'ZesharCRMCoreBundle:CRUD:lead_opportunity_edit.html.twig';
        } elseif ('show' === $name) {
            return 'ZesharCRMCoreBundle:CRUD:lead_opportunity_show.html.twig';
        } elseif ('list' === $name) {
            return 'ZesharCRMCoreBundle:CRUD:lead_opportunity_list.html.twig';
        } elseif ('create' === $name) {
            return 'ZesharCRMCoreBundle:CRUD:lead_opportunity_create.html.twig';
        } elseif ('listDeleted' === $name) {
            return 'ZesharCRMCoreBundle:CRUD:deleted_lead_list.html.twig';
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
            ->add('name')
            ->add('contactCard.firstName', NULL, array(
                'label' => 'First Name',
            ))
            ->add('contactCard.middleInitial', NULL, array(
                'label' => 'Middle Initial',
            ))
            ->add('contactCard.phone', 'zeshar_contactcard_phone')
            ->add('contactCard.lastName', NULL, array(
                'label' => 'Last Name',
            ))
            ->add('type', 'doctrine_orm_choice', array(
                'field_type' => 'choice',
                'field_options' => array(
                    'choices' => LeadType::getHumanTitlesMap(),
                ),
            ))
//            ->add('contactCard.contacts.value',array(), array('label' => 'Contacts',))
            ->add('status', 'doctrine_orm_choice', array(
                'field_type' => 'choice',
                'field_options' => array(
                    'choices' => DealStatus::getHumanTitlesMap(),
                    'label' => 'Sales Status'
                ),
            ))
            ->add('mailStatus', 'doctrine_orm_choice', array(
                'field_type' => 'choice',
                'field_options' => array(
                    'choices' => $this->getBooleanChoices(),
                ),
            ))
            ->add('contactCard.email', 'zeshar_contactcard_email')
            ->add('contactCard.callStatus', 'zeshar_contactcard_callstatus')
//            ->add('callStatus', 'doctrine_orm_choice', array(
//                'field_type' => 'choice',
//                'field_options' => array(
//                    'choices' => LeadContactStatus::getHumanTitlesMap(),
//                ),
//            ))
            ->add('leadCategory')
            ->add('leadCampaign')
            ->add('leadSource')
            ->add('purchasedAt', 'doctrine_orm_date')
            ->add('purchaseAmount')
            ->add('estimatedValue')
            ->add('creator')
            ->add('assignee')
            ->add('createdAt', 'zeshar_date_day')
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

        $queryBuilder->leftJoin(sprintf('%s.contactCard', $alias), 'cfn');
        $queryBuilder->andWhere('CONCAT(cfn.firstName, CONCAT(\' \', cfn.lastName)) LIKE :term_fn');
        $queryBuilder->setParameter(':term_fn', '%' . $value['value'] . '%');

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $filters = $this->getFilterParameters();
        $filter = '';
        if (isset($filters['leadCampaign']['value'])) {
            $filter = $filters['leadCampaign']['value'];
        }
        $listMapper
//            ->addIdentifier('id', NULL, array(
//                'label' => 'Lead',
//                'route' => array(
//                    'name' => 'show',
//                ),
//            ))
//            ->addIdentifier('name')
//            ->add('contactCard.firstName', NULL, array(
//                'label' => 'First Name',
//            ))
//            ->add('contactCard.middleInitial', NULL, array(
//                'label' => 'Middle Initial',
//            ))
//            ->add('contactCard.lastName', NULL, array(
//                'label' => 'Last Name',
//            ))
//            ->add('contactCard.fullName', NULL, array(
//                'label' => 'Name',
//            ))

            ->addIdentifier('contactCard.fullName', null, array(
                'label' => 'Name',
                'route' => array(
                    'name' => 'show',
//                    'identifier_parameter_name' => 'filter[leadCampaign][value]',
                    'parameters' => array('leadCampaign' => $filter),
                ),
            ))

            ->add('contactCard.phone', null, array(
                'label' => 'Phone',
                'template' => 'ZesharCRMCoreBundle:ListField:lead_phone.html.twig',
                'route' => array(
                    'name' => 'show',
                ),
                'attr' => array(
                    'data' => 'phone'
                )
            ))
            ->add('leadCampaign', null, array(
                'label' => 'Activity',
                'route' => array(
                    'name' => 'show',
                ),
                'template' => 'ZesharCRMCoreBundle:ListField:list_field_raw_value.html.twig',
                'admin_code' => 'zeshar_crm_core.admin.activity'
            ))
//            ->add('statusString', null, array(
//                'label' => 'Status',
//            ))
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
            ->add('type', null, array(
                'label' => 'Status',
                'template' => 'ZesharCRMCoreBundle:ListField:lead_type.html.twig',
            ))
            ->add('leadSource', null, array(
                'label' => 'Source',
                'route' => array(
                    'name' => 'show',
                ),
                'template' => 'ZesharCRMCoreBundle:ListField:list_field_raw_value.html.twig',
            ))
//            ->add('purchasedAt', 'date')
//            ->add('purchaseAmount')
//            ->add('estimatedValue')
//            ->add('creator', null, array(
//                'route' => array(
//                    'name' => 'show',
//                ),
//            ))
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
            ->add('status', null, array())
//            ->add('updatedAt')
//            ->add('_action', 'actions', array(
//                'actions' => array(
//                    'show' => array(),
//                    'edit' => array(),
//                    'delete' => array(),
//                    'update' => array(
//                        'template' => 'ZesharCRMLeadScoringBundle:ScoringCRUD:list__action_lead_scoring.html.twig'
//                    ),
//                    'warmup' => array(
//                        'template' => 'ZesharCRMCoreBundle:LeadsCRUD:list__action_warmup.html.twig'
//                    ),
//                    'close' => array(
//                        'template' => 'ZesharCRMCoreBundle:LeadsCRUD:list__action_close.html.twig'
//                    ),
//                    'cancel' => array(
//                        'template' => 'ZesharCRMCoreBundle:LeadsCRUD:list__action_cancel.html.twig'
//                    ),
//                    'reopen' => array(
//                        'template' => 'ZesharCRMCoreBundle:LeadsCRUD:list__action_reopen.html.twig'
//                    ),
//                )
//            ))
        ;

        parent::configureListFields($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('type', 'choice', array(
                'choices' => LeadType::getHumanTitlesMap(),
            ))
            ->add('status', 'choice', array(
                'choices' => DealStatus::getHumanTitlesMap(),
                'label' => 'Sales Status'
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
//            ->add('leadCategory', 'sonata_type_model', array(
//                'label' => 'Product',
//                'required' => TRUE,
//            ))
            ->add('leadCampaign', 'entity', array(
                'label' => 'Activity',
                'required' => FALSE,
                'class' => 'ZesharCRM\Bundle\CoreBundle\Entity\Activity'
                ),
                array('admin_code' => 'zeshar_crm_core.admin.activity')
            )
//            ->add('leadSource', 'sonata_type_model', array(
//                'label' => 'Source',
//                'required' => FALSE,
//            ))
            ->add('purchasedAt', 'date', array(
                'required' => FALSE,
            ))
            ->add('purchaseAmount')
            ->add('estimatedValue')
//            ->add('assignee', 'sonata_type_model', array(
//                'required' => FALSE,
//            ))
            ->add('newAttachment', 'textarea', array(
                'required' => FALSE,
                'label' => 'Add Comment',
            ))
            ->add('newAttachmentFile', 'file', array(
                'required' => false,
                'data_class' => NULL,
                'label' => 'Add File',
            ))
            ->add('attachments', 'sonata_type_collection', array(
                'by_reference' => TRUE,
                'required' => FALSE,
            ), array(
                'edit' => 'inline',
                'inline' => 'table',
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
            ->add('typeString', array(), array(
                'label' => 'Type',
            ))
            ->add('statusString', array(), array(
                'label' => 'Sales Status',
            ))
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
            ->add('leadCampaign', null, array(
                'label' => 'Activity',
                'route' => array(
                    'name' => 'show',
                ),
                'admin_code' => 'zeshar_crm_core.admin.activity'
            ))
            ->add('leadSource', null, array(
                'label' => 'Source',
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
                'template' => 'ZesharCRMCoreBundle:CRUD:show_lead_attachments.html.twig',
            ))
        ;
        
        parent::configureShowFields($showMapper);
    }
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('close', $this->getRouterIdParameter() . '/close');
        $collection->add('cancel', $this->getRouterIdParameter() . '/cancel');
        $collection->add('reopen', $this->getRouterIdParameter() . '/reopen');
        $collection->add('warmup', $this->getRouterIdParameter() . '/warmup');
//        $collection->add('history', $this->getRouterIdParameter() . '/history');
//        $collection->add('historyViewRevision', $this->getRouterIdParameter() . '/revision/{revision}');
        $collection->add('update', '{lead}/update');
        $collection->add('listLeads', 'listLeads');
        $collection->add('listDeleted', 'listDeleted');
    }

    public function validate(ErrorElement $errorElement, $object)
    {
//        $errorElement
//            ->with('contactCard')
//                ->assertNotNull()
//                ->assertNotBlank()
//            ->end()
//        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getExportFields()
    {
        $fieldsArray = array();
        
        $fieldsArray['First Name'] = 'contactCard.firstName';
        $fieldsArray['Last Name'] = 'contactCard.lastName';
        $fieldsArray['Address'] = 'contactCard.streetAddress';
        $fieldsArray['City'] = 'contactCard.city';
        $fieldsArray['State'] = 'contactCard.state';
        $fieldsArray['Zip'] = 'contactCard.zip';
        $fieldsArray['Email'] = 'contactCard.email';
        $fieldsArray['Phone'] = 'contactCard.phone';
        $fieldsArray['Previous Carrier Police'] = 'previousCarrierPolice';
        $fieldsArray['Purchase Date'] = 'purchasedAt';
        $fieldsArray['Purchase Amount'] = 'purchaseAmount';
        $fieldsArray['Est. Value'] = 'estimatedValue';

        return $fieldsArray;
    }
    
    public function setupImportWorkflow(ImportWorkflow $workflow)
    {
        $inverseMapping = array_flip($this->getExportFields());
        $workflow->addValueConverter($inverseMapping['purchasedAt'], new ImportValueConverter\DateTimeValueConverter());
    }
    
    public function getImportWorkflowWriter(\Doctrine\ORM\EntityManager $entityManager)
    {
        $workflowWriter = new \ZesharCRM\Bundle\CoreBundle\Helper\ImportLeadDoctrineWriter($entityManager, $this->getExportFields());
        
        // set current logged in user as default leads creator
        if ($user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser()) {
            $workflowWriter->setLeadsDefaultCreator($user);
        }
        
        return $workflowWriter;
    }
    
    /**
     * Hack
     * @param Lead $object
     */
    public function bindAttachments($object)
    {
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
            $leadAttachment = new \ZesharCRM\Bundle\CoreBundle\Entity\LeadAttachment();
            $leadAttachment
                ->setAttachment($attachment)
                ->setLead($object)
            ;
            $em->persist($attachment);
            $em->persist($leadAttachment);
            $em->flush();
        }
    }
    
    public function postPersist($object)
    {
        $this->bindAttachments($object);
    }
    
    public function postUpdate($object)
    {
        $this->bindAttachments($object);
    }

    public function getBatchActions()
    {
        $lists = $this->getModelManager()->createQuery('ZesharCRM\Bundle\CoreBundle\Entity\User', 'u')->execute();
        $listsCampaign = $this->getModelManager()->createQuery('ZesharCRM\Bundle\CoreBundle\Entity\Activity', 'a')->execute();

        $listsArray = array();
        $listsCampaignArray = array();

        foreach ($lists as $list)
        {
            $listsArray[$list->getId()] = $list->getUsername();
        }

        foreach ($listsCampaign as $list)
        {
            $listsCampaignArray[$list->getId()] = $list->getTitle();
        }
       // print_r($listsArray);die;
        $actions = parent::getBatchActions();

        $actions['reassign'] = array(
            'label' => 'Reassign',
            'ask_confirmation' => true,
            'secondary' => $listsArray,
        );

        $actions['reassignCampaign'] = array(
            'label' => 'Reassign Activity',
            'ask_confirmation' => true,
            'secondary' => $listsCampaignArray,
        );

        return $actions;
    }
}
