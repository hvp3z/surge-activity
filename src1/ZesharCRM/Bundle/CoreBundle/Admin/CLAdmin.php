<?php

namespace ZesharCRM\Bundle\CoreBundle\Admin;

use ZesharCRM\Bundle\CoreBundle\Event\SonataAdminConfigureEvent;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class CLAdmin extends Admin
{

    protected $maxTitleLength = 30;


    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, $class, $baseControllerName);
    }

    public function prePersist($object)
    {
        if(method_exists($object, 'getCreator') && !$object->getCreator()){
            if (method_exists($object, 'setCreator')) {
                if ($user = $this->getLoggedInUser()) {
                    $object->setCreator($user);
                }
            }
        }
    }

    protected function getBooleanChoices()
    {
        return array(
            0 => 'no',
            1 => 'yes',
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function getExportFormats()
    {
        return array(
            'csv', 
            'xls', 
        );
    }
    
    public function toString($object)
    {
        if (method_exists($object, '__toString') && (null !== $object->__toString()) ) {
            return (string) $object;
        }
        return $this->getLabel();
    }
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        foreach ($formMapper->getFormBuilder()->all() as $field) {
            $fieldTypesToApply = array(
                'text',
                'choice',
                'integer',
                'date',
//                'zesharcrm_sonata_ex_type_boolean',
                'sonata_type_model',
//                'entity',
            );

            if (in_array($field->getType()->getName(), $fieldTypesToApply)) {
                $options = $field->getOptions();            // get the options
                $type = $field->getType()->getName();       // get the name of the type
                $fieldName = $field->getName();
                $options['attr']['class'] = 'form-control';


                $formMapper->add($field->getName(), $type, $options); // replace the field
            }
        }        
    }
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->callEvent(__FUNCTION__, func_get_args());
        
        if (!$this->userIsPrivileged()) {
            if ($listMapper->has('assignee')) {
                $listMapper->remove('assignee');
            }
        }
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
                if (property_exists($this->getClass(), 'assignee') && property_exists($this->getClass(), 'creator')) {
                    $part = $datagrid->getQuery()->getQueryBuilder();
                    $alias = $part->getDqlPart('from')[0]->getAlias();
                    $datagrid
                        ->getQuery()
                        ->getQueryBuilder()
                        ->andWhere("(IF({$alias}.assignee != 0, {$alias}.assignee, {$alias}.creator) = :user_id)")
                        ->setParameter('user_id', $user->getId())
                    ;
                }
            }
        }

        return $this->datagrid;
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        
        if (!$this->userIsPrivileged()) {
            if ($datagridMapper->has('assignee')) {
                $datagridMapper->remove('assignee');
            }
        }
        
        $this->callEvent(__FUNCTION__, func_get_args());
        
    }
    
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->callEvent(__FUNCTION__, func_get_args());
    }
    
    protected function callEvent($methodName, array $args = array()) {
        $this
            ->getConfigurationPool()
            ->getContainer()
            ->get('event_dispatcher')
            ->dispatch(SonataAdminConfigureEvent::getEventId(), new SonataAdminConfigureEvent($this, $methodName, $args));
        ;
    }
    
    /**
     * Checks if current logged in user is Agency Owner or superadmin
     * @return bool
     */
    protected function userIsPrivileged()
    {
        if ($user = $this->getLoggedInUser()) {
            $roles = $user->getRoles();
            return !(!in_array('ROLE_AGENCY_OWNER', $roles) && !in_array('ROLE_SUPER_ADMIN', $roles));
        }
        return FALSE;
    }
    
    protected function getLoggedInUser()
    {
        if ($this->getConfigurationPool()->getContainer()->get('security.context')->getToken() && $user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser()) {
            return $user;
        }
        return NULL;
    }
    
    public function isGranted($name, $object = null) {
        
        if (!is_null($object)) {
            if (!$this->userIsPrivileged()) {
                if ($user = $this->getLoggedInUser()) {
                    if (method_exists($object, 'getAssignee') && method_exists($object, 'getCreator')) {
//                        if (($object->getAssignee()->getId() == $user->getId()) || ( $object->getCreator()->getId() == $user->getId())) {
//                            return TRUE;
//                        }
//                        return FALSE;
                    }
                }
            }
        }
        
        return parent::isGranted($name, $object);
        
    }
    
}
