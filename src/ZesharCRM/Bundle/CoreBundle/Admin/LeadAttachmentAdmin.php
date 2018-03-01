<?php

namespace ZesharCRM\Bundle\CoreBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Validator\ErrorElement;

class LeadAttachmentAdmin extends CLAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('attachment', 'sonata_type_model_list', array(
                'btn_list' => FALSE,
                'btn_delete' => FALSE,
                'btn_add' => 'Fill in attachment',
                'required' => TRUE,
            ), array(
                'placeholder' => 'Empty attachment',
            ))
        ;
        
        parent::configureFormFields($formMapper);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        
    }
    
    public function generateAttachmentCreateURL($object)
    {
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager(); 
        $className = $em->getClassMetadata(get_class($object))->getName();
        return $this
            ->getConfigurationPool()
            ->getContainer()
            ->get('zeshar_crm_core.admin.attachment')
            ->generateUrl('create', array(
                'object' => $object->getId(),
                'type' => $className,
            )
        );
    }
    
    public function generateAttachmentEditURL($object)
    {
        return $this
            ->getConfigurationPool()
            ->getContainer()
            ->get('zeshar_crm_core.admin.attachment')
            ->generateUrl('edit', array(
                'id' => $object->getId(),
            )
        );
    }
    
    public function generateAttachmentRemoveURL($attachment)
    {
        return $this
            ->getConfigurationPool()
            ->getContainer()
            ->get('zeshar_crm_core.admin.attachment')
            ->generateObjectUrl('delete', $attachment);
    }
    
}
