<?php

namespace ZesharCRM\Bundle\CoreBundle\Helper;

use Ddeboer\DataImport\Writer\DoctrineWriter as ImportDoctrineWriter;
use Symfony\Component\Security\Acl\Exception\Exception;

class ImportLeadDoctrineWriter extends ImportDoctrineWriter
{

    private $_leadsDefaultCreator = NULL;
    private $_fieldsMapping;
    private $index;

    public function __construct(\Doctrine\ORM\EntityManager $entityManager, array $exportFields)
    {
        parent::__construct($entityManager, 'ZesharCRMCoreBundle:Lead', NULL);
        $this->_fieldsMapping = $exportFields;
    }

    /**
     * {@inheritdoc}
     */
    public function writeItem(array $item)
    {
        $this->counter++;
        $lead = new \ZesharCRM\Bundle\CoreBundle\Entity\Lead();
        
        // remap item
        $mappedItem = array();
        foreach ($item as $key => $value) {
            if (isset($this->_fieldsMapping[$key])) {
                $mappedItem[$this->_fieldsMapping[$key]] = $value;
            }
        }
        $item = $mappedItem;

        // If the table was not truncated to begin with, find current entities
        // first
        if (false === $this->truncate) {
            if ($this->index) {
                $lead = $this->entityRepository->findOneBy(
                    array($this->index => $item[$this->index])
                );
            } else {
                $lead = $this->entityRepository->find(current($item));
            }
        }

        if (!$lead) {
            $className = $this->entityMetadata->getName();
            $lead = $this->getNewInstance($className, $item);
        }

        $fieldNames = array_merge($this->entityMetadata->getFieldNames(), $this->entityMetadata->getAssociationNames());
        foreach ($fieldNames as $fieldName) {
            $value = null;
            if (isset($item[$fieldName])) {
                $value = $item[$fieldName];
            } elseif (method_exists($item, 'get' . ucfirst($fieldName))) {
                $value = $item->{'get' . ucfirst($fieldName)};
            }

            if (null === $value) {
                continue;
            }

            if (!($value instanceof \DateTime)
                || $value != $this->entityMetadata->getFieldValue($lead, $fieldName)
            ) {
                $setter = 'set' . ucfirst($fieldName);
                $this->setValue($lead, $value, $setter);
            }
        }

        // custom lead adjustments
        $date = new \DateTime();
        $leadSource = $this->entityManager->getRepository('ZesharCRMCoreBundle:LeadSource')->find(3);

        $lead
            ->setName('Lead')
            ->setType(\ZesharCRM\Bundle\CoreBundle\Enum\LeadType::COLD)
            ->setStatus(\ZesharCRM\Bundle\CoreBundle\Enum\DealStatus::PENDING)
            ->setLeadSource($leadSource)
            ->setCreator($this->_leadsDefaultCreator)
            ->setUpdatedAt($date->modify('+1 sec'))
        ;
        
        // create contact card
        $contactCard = new \ZesharCRM\Bundle\CoreBundle\Entity\ContactCard();
        $contactCard
            ->setFirstName($item['contactCard.firstName'])
            ->setLastName($item['contactCard.lastName'])
            ->setStreetAddress($item['contactCard.streetAddress'])
            ->setCity($item['contactCard.city'])
            ->setState($item['contactCard.state'])
            ->setZip($item['contactCard.zip'])
            ->setType(1)
        ;

        if (!empty($item['contactCard.phone'])) {
            $phone = new \ZesharCRM\Bundle\CoreBundle\Entity\Contact();
            $phone
                ->setType(\ZesharCRM\Bundle\CoreBundle\Enum\ContactType::GENERIC_PHONE)
                ->setValue($item['contactCard.phone'])
                ->setContactCard($contactCard)
                ->setIsDefault(true)
            ;
            $contactCard->addContact($phone);
        }

        if (!empty($item['contactCard.email'])) {
            $email = new \ZesharCRM\Bundle\CoreBundle\Entity\Contact();
            $email
                ->setType(\ZesharCRM\Bundle\CoreBundle\Enum\ContactType::EMAIL)
                ->setValue($item['contactCard.email'])
                ->setContactCard($contactCard)
                ->setIsDefault(false)
            ;
            $contactCard->addContact($email);
        }

        $lead->setContactCard($contactCard);

        // save lead
        $date = new \DateTime('today');

        $lead->setCreatedAt($date);
        $this->entityManager->merge($lead);
        $this->entityManager->flush();
        $this->entityManager->clear();

        if (($this->counter % $this->batchSize) == 0) {
            $this->entityManager->flush();
            $this->entityManager->clear();
        }

        return $this;
    }
    
    public function setLeadsDefaultCreator(\ZesharCRM\Bundle\CoreBundle\Entity\User $creator) {
        $this->_leadsDefaultCreator = $creator;
    }
}