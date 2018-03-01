<?php

namespace ZesharCRM\Bundle\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use ZesharCRM\Bundle\CoreBundle\Enum\ContactCardType;
use ZesharCRM\Bundle\CoreBundle\Enum\DNCStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\ContactType;
use ZesharCRM\Bundle\CoreBundle\Enum\ContactCardNetworkType;
use ZesharCRM\Bundle\CoreBundle\Enum\ContactCardTypeWithNetworkType;

use Sonata\AdminBundle\Validator\ErrorElement;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use ZesharCRM\Bundle\CoreBundle\Entity\Contact;


class ContactCardAdmin extends CLAdmin
{
    
    public function getTemplate($name) {
        if ('edit' === $name) {
            return 'ZesharCRMCoreBundle:CRUD:contact_card_edit.html.twig';
        } elseif ('list' === $name) {
            return 'ZesharCRMCoreBundle:CRUD:lead_opportunity_list.html.twig';
        }
        //return 'SonataDoctrineORMAdminBundle:CRUD:edit_orm_one_to_many.html.twig';
        return parent::getTemplate($name);
    }
    
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

        $datagridMapper
            ->add('id')
            ->add('firstName')
            ->add('middleInitial', null, array(
                'label' => 'MI'
            ))
            ->add('lastName')
            ->add('streetAddress')
            ->add('city')
            ->add('state')
            ->add('zip')
            ->add('genericPhone', 'doctrine_orm_callback', array(
                'callback'   => array($this, 'getGenericPhone'),
                'field_type' => 'text'
            ))
            ->add('cellPhone', 'doctrine_orm_callback', array(
                'callback'   => array($this, 'getCellPhone'),
                'field_type' => 'text'
            ))
            ->add('workPhone', 'doctrine_orm_callback', array(
                'callback'   => array($this, 'getWorkPhone'),
                'field_type' => 'text'
            ))
//            ->add('contacts.')
//            ->add('genericPhone')
//            ->add('cellPhone')
//            ->add('email')
            ->add('typeStringWithNetworkType', 'doctrine_orm_callback', array(
                'field_type' => 'choice',
                'callback'   => array($this, 'getTypeStringWithNetworkType'),
                'field_options' => array(
                    'choices' => ContactCardTypeWithNetworkType::getHumanTitlesMap(),
                ),
            ))
            ->add('email', 'doctrine_orm_callback', array(
                'callback'   => array($this, 'getEmailFilter'),
                'field_type' => 'text'
            ))
//            ->add('customContactsString')
//            ->add('contacts.value',array(), array('label' => 'Contacts',))
        ;

    }

    public function getEmailFilter($queryBuilder, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $queryBuilder->leftJoin(sprintf('%s.contacts', $alias), 'c');
        $queryBuilder->andWhere('c.value=:email AND c.type=:typeEmail');
        $queryBuilder->setParameter('email', $value['value']);
        $queryBuilder->setParameter('typeEmail', ContactType::EMAIL);

        return true;
    }

    public function getTypeStringWithNetworkType($queryBuilder, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

       // $queryBuilder->addSelect(sprintf('%s.type', $alias) . ' as cc');

        switch($value['value']){
            case ContactCardTypeWithNetworkType::RNS_ASSOCIATES:
                $queryBuilder->andWhere(sprintf('%s.type', $alias).'=:type AND ' . sprintf('%s.networkType', $alias) . '=:networkType');
                $queryBuilder->setParameter('type', ContactCardType::RNS);
                $queryBuilder->setParameter('networkType', ContactCardNetworkType::ASSOCIATES);
                break;
            case ContactCardTypeWithNetworkType::RNS_BUSINESS_CONTACT:
                $queryBuilder->andWhere(sprintf('%s.type', $alias).'=:type AND ' . sprintf('%s.networkType', $alias) . '=:networkType');
                $queryBuilder->setParameter('type', ContactCardType::RNS);
                $queryBuilder->setParameter('networkType', ContactCardNetworkType::BUSINESS_CONTACT);
                break;
            case ContactCardTypeWithNetworkType::RNS_FRIENDS:
                $queryBuilder->andWhere(sprintf('%s.type', $alias).'=:type AND ' . sprintf('%s.networkType', $alias) . '=:networkType');
                $queryBuilder->setParameter('type', ContactCardType::RNS);
                $queryBuilder->setParameter('networkType', ContactCardNetworkType::FRIENDS);
                break;
            case ContactCardTypeWithNetworkType::RNS_RELATIVE:
                $queryBuilder->andWhere(sprintf('%s.type', $alias).'=:type AND ' . sprintf('%s.networkType', $alias) . '=:networkType');
                $queryBuilder->setParameter('type', ContactCardType::RNS);
                $queryBuilder->setParameter('networkType', ContactCardNetworkType::RELATIVE);
                break;
            case ContactCardTypeWithNetworkType::RNS_SOCIAL_MEDIA:
                $queryBuilder->andWhere(sprintf('%s.type', $alias).'=:type AND ' . sprintf('%s.networkType', $alias) . '=:networkType');
                $queryBuilder->setParameter('type', ContactCardType::RNS);
                $queryBuilder->setParameter('networkType', ContactCardNetworkType::OCIAL_MEDIA);
                break;
            default:
                $queryBuilder->andWhere(sprintf('%s.type', $alias).'=:type');
                $queryBuilder->setParameter('type', $value['value']);
        }

        return true;
    }

    public function getGenericPhone($queryBuilder, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $queryBuilder->leftJoin(sprintf('%s.contacts', $alias), 'cg');
        $queryBuilder->andWhere('cg.value LIKE :genericPhone AND cg.type=:typeGenericPhone');
        $queryBuilder->setParameter('genericPhone', '%' . $value['value'] . '%');
        $queryBuilder->setParameter('typeGenericPhone', ContactType::GENERIC_PHONE);

        return true;
    }

    public function getCellPhone($queryBuilder, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $queryBuilder->leftJoin(sprintf('%s.contacts', $alias), 'c');
        $queryBuilder->andWhere('c.value LIKE :cellPhone AND c.type=:typeCellPhone');
        $queryBuilder->setParameters(array('cellPhone' => $value['value'], 'typeCellPhone' => ContactType::CELL_PHONE));

        return true;
    }

    public function getWorkPhone($queryBuilder, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $queryBuilder->leftJoin(sprintf('%s.contacts', $alias), 'c');
        $queryBuilder->andWhere('c.value LIKE :workPhone AND c.type=:typeWorkPhone');
        $queryBuilder->setParameters(array('workPhone' => $value['value'], 'typeWorkPhone' => ContactType::CELL_PHONE));

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->addIdentifier('firstName', null, array(
                'route' => array(
                    'name' => 'show',
                ),
            ))
            ->addIdentifier('middleInitial', null, array(
                'route' => array(
                    'name' => 'show',
                ),
                'label' => 'MI'
            ))
            ->addIdentifier('lastName', null, array(
                'route' => array(
                    'name' => 'show',
                ),
            ))
            ->add('streetAddress')
            ->add('city')
            ->add('state')
            ->add('zip')
            ->add('genericPhone',null,array(
                'template' => 'ZesharCRMCoreBundle:CRUD:list_orm_many_to_one_custom.html.twig',
                'attr' => array(
                    'data' => 'phone'
                )
            ))
            ->add('cellPhone',null,array(
                'template' => 'ZesharCRMCoreBundle:CRUD:list_orm_many_to_one_custom.html.twig',
                'attr' => array(
                    'data' => 'phone'
                )))
            ->add('workPhone',null,array(
                'template' => 'ZesharCRMCoreBundle:CRUD:list_orm_many_to_one_custom.html.twig',
                'attr' => array(
                    'data' => 'phone'
                )))
            ->add('email',null,array(
                'template' => 'ZesharCRMCoreBundle:CRUD:contact_card_list_email.html.twig',
                'attr' => array(
                    'data' => 'email'
                )))
            ->add('typeStringWithNetworkType', array(), array(
                'label' => 'Type',
            ))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'ZesharCRMCoreBundle:CRUD:contact_card_list_field_action_show.html.twig'),
                    'edit' => array('template' => 'ZesharCRMCoreBundle:CRUD:contact_card_list_field_action_edit.html.twig'),
                    'delete' => array('template' => 'ZesharCRMCoreBundle:CRUD:contact_card_list_field_action_delete.html.twig'),
                ),
                'template' => 'ZesharCRMCoreBundle:CRUD:contact_card_list_field_action.html.twig'
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('contacts', 'sonata_type_collection', array(
                'required' => TRUE,
                'by_reference' => TRUE,
            ), array(
                'edit' => 'inline',
                'inline' => 'table',
            ))
//            ->add('contacts',
//                'collection',
//                array(
//                    'type' => 'entity',
//                    'allow_add' => true,
//                    'allow_delete' => true,
//                    'by_reference' => true,
//                    'label' => 'Contacts',
//                    'options' => array(
//                        'class' => 'ZesharCRMCoreBundle:Contact',
//                        'property' => 'value',
//                        'label' => false
//                    )
//                )
//            )
//            ->add('contacts', 'sonata_type_model_list', array(
//                'label' => 'Contacts',
//                'btn_delete'    => false,
//                'btn_add'    => true,
//                'required' => true,
//                'by_reference' => FALSE
//
//            ),array(
//                'placeholder' => 'No contact selected',
//            ))

            ->add('firstName')
            ->add('middleInitial', null, array(
                'label' => 'MI'
            ))
            ->add('lastName')
            ->add('type', 'choice', array(
                'choices' => ContactCardType::getHumanTitlesMap(),
            ))
            ->add('networkType', 'choice', array(
                'choices' => ContactCardNetworkType::getHumanTitlesMap(),
                'required' => false,
                'attr' => array(
                    'style' => 'display:none'
                ),
                'label_attr' => array(
                    'class' => 'networkTypeLabel ',
                    'style' => 'display:none'
                ),
            ))
            ->add('streetAddress')
            ->add('city')
            ->add('state')
            ->add('zip')
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
            ->add('firstName')
            ->add('middleInitial', null, array(
                'label' => 'MI'
            ))
            ->add('lastName')
            ->add('streetAddress')
            ->add('city')
            ->add('state')
            ->add('zip')
            ->add('genericPhone',null,array(
                'template' => 'ZesharCRMCoreBundle:CRUD:show_orm_many_to_one_custom.html.twig'
            ))
            ->add('cellPhone',null,array(
                'template' => 'ZesharCRMCoreBundle:CRUD:show_orm_many_to_one_custom.html.twig'
            ))
            ->add('workPhone',null,array(
                'template' => 'ZesharCRMCoreBundle:CRUD:show_orm_many_to_one_custom.html.twig'
            ))
            ->add('typeString', null, array(
                'label' => 'Type'
            ));

        if ($this->getSubject()->getType() == ContactCardType::RNS) {
            $showMapper->add('networkTypeString', null, array(
                'label' => 'Network Type'
            ));
        }

        $showMapper->add('email')
            ->add('customContactsString', null, array(
                'label' => 'Custom Contacts',
            ))
        ;
    }
    
    public function postPersist($contactCard)
    {
        $this->bindContacts($contactCard);
    }

    public function postUpdate($contactCard)
    {
        $this->bindContacts($contactCard);
    }

    /**
     * Hack to store contact card in contact; alsp manage contact default flag
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\ContactCard $contactCard
     */
    public function bindContacts(\ZesharCRM\Bundle\CoreBundle\Entity\ContactCard $contactCard) {
        $em = $this->modelManager->getEntityManager('ZesharCRM\Bundle\CoreBundle\Entity\Contact');

        $contactIsPhone = function($contact) {
            return in_array($contact->getType(), array(ContactType::GENERIC_PHONE, ContactType::CELL_PHONE, ContactType::WORK_PHONE), 1);
        };
        $fakePhoneType = 1000;

        $defaultContacts = array();
        foreach ($contactCard->getContacts() as $contact) {
            $type = $contactIsPhone($contact) ? $fakePhoneType : $contact->getType();

            if (!array_key_exists($type, $defaultContacts)) {
                if ($contact->getIsDefault()) {
                    $defaultContacts[$type] = $contact;
                }
            }

            $contact->setIsDefault(FALSE);
        }

        foreach ($contactCard->getContacts() as $contact) {
            $checkType = $contactIsPhone($contact) ? $fakePhoneType : $contact->getType();

            if (array_key_exists($checkType, $defaultContacts)) {
                if ($defaultContacts[$checkType]->getId() === $contact->getId()) {
                    $contact->setIsDefault(TRUE);
                }
            } else {
                $defaultContacts[$checkType] = $contact;
                $contact->setIsDefault(TRUE);
            }

            $contact->setContactCard($contactCard);
            $em->flush($contact);
        }
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('winBackQuote', $this->getRouterIdParameter() . '/win_back');
    }

//    public function validate(ErrorElement $errorElement, $object)
//    {
//        $errorElement
//            ->assertCallback(array('zipCodeValidation'))
//        ;
//    }

}
