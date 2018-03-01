<?php

namespace ZesharCRM\Bundle\CoreBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Validator\ErrorElement;

class AttachmentAdmin extends CLAdmin
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
        $listMapper
            ->add('leadAttachment.lead.id', null, array(
                'label' => 'Related Lead ID',
            ))
            ->add('opportunityAttachment.opportunity.id', null, array(
                'label' => 'Related Opportunity ID',
            ))
            ->add('text')
            ->add('downloadLink', 'html', array(
                'title' => 'File',
            ))
            ->add('creator', null, array(
                'route' => array(
                    'name' => 'show',
                ),
            ))
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }
    
    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('leadAttachment.lead.id', null, array(
                'label' => 'Related Lead ID',
            ))
            ->add('opportunityAttachment.opportunity.id', null, array(
                'label' => 'Related Opportunity ID',
            ))
            ->add('text')
            ->add('downloadLink', NULL, array(
                'title' => 'File',
                'safe' => TRUE,
            ))
            ->add('creator', null, array(
                'route' => array(
                    'name' => 'show',
                ),
            ))
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('text')
            ->add('file', 'file', array(
                'required' => false,
                'data_class' => NULL,
            ))
        ;
        $objectId = $objectType = NULL;
        if ($params = $this->getConfigurationPool()->getContainer()->get('request')->query->all()) {
            if (!empty($params['object'])) {
                $objectId = (int) $params['object'];
            }
            if (!empty($params['type'])) {
                $objectType = $params['type'];
            }
        }
        $formMapper->add('objectId', 'hidden', array(
            'data' => (int) $objectId,
            'mapped' => FALSE,
        ));
        $formMapper->add('objectType', 'hidden', array(
            'data' => $objectType,
            'mapped' => FALSE,
        ));
        
        parent::configureFormFields($formMapper);
    }
    
    public function postPersist($object) {
        if ($requestData = $this->getConfigurationPool()->getContainer()->get('request')->request->all()) {
            foreach ($requestData as $requestDataItem) {
                if (is_array($requestDataItem) && !empty($requestDataItem['objectId']) && !empty($requestDataItem['objectType'])) {
                    $objectId = $requestDataItem['objectId'];
                    $objectType = $requestDataItem['objectType'];
                    $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager(); 
                    if ($objectType === 'ZesharCRM\Bundle\CoreBundle\Entity\Lead') {
                        $leadAttachment = new \ZesharCRM\Bundle\CoreBundle\Entity\LeadAttachment();
                        $repository = $this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository('ZesharCRMCoreBundle:Lead');
                        if ($lead = $repository->findOneById((int) $objectId)) {
                            $leadAttachment->setLead($lead);
                            $leadAttachment->setAttachment($object);
                            $em->persist($leadAttachment);
                            $em->flush();
                            
                            $this->getConfigurationPool()->getContainer()->get('session')->set('zsh_attachment_redirect_url', $this
                                ->getConfigurationPool()
                                ->getContainer()
                                ->get('zeshar_crm_core.admin.lead')
                                ->generateUrl('show', array(
                                        'id' => (int) $objectId,
                                    )
                                )
                            );
                        }
                    } elseif ($objectType === 'ZesharCRM\Bundle\CoreBundle\Entity\Opportunity') {
                        $opportunityAttachment = new \ZesharCRM\Bundle\CoreBundle\Entity\OpportunityAttachment();
                        $repository = $this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository('ZesharCRMCoreBundle:Opportunity');
                        if ($opportunity = $repository->findOneById((int) $objectId)) {
                            $opportunityAttachment->setLead($opportunity);
                            $opportunityAttachment->setAttachment($object);
                            $em->persist($opportunityAttachment);
                            $em->flush();
                            
                            $this->getConfigurationPool()->getContainer()->get('session')->set('zsh_attachment_redirect_url', $this
                                ->getConfigurationPool()
                                ->getContainer()
                                ->get('zeshar_crm_core.admin.opportunity')
                                ->generateUrl('show', array(
                                        'id' => (int) $objectId,
                                    )
                                )
                            );
                        }
                    }
                    break;
                }
            }
        }
    }
    
    public function toString($object) {
        if ( ($text = $object->getText()) && (!preg_match('/^ +$/', $text)) ) {
            if (mb_strlen($text) > $this->maxTitleLength) {
                return mb_substr($text, 0, $this->maxTitleLength) . '...';
            } else {
                return $text;
            }
        } elseif ($filename = $object->getFilename()) {
            return $filename;
        } else {
            return '[attachment]';
        }
    }
    
}
