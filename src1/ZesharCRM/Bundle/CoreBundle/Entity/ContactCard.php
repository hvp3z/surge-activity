<?php

namespace ZesharCRM\Bundle\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ZesharCRM\Bundle\CoreBundle\Enum\ContactCardType;
use ZesharCRM\Bundle\CoreBundle\Enum\ContactCardNetworkType;
use ZesharCRM\Bundle\CoreBundle\Enum\ContactType;
use ZesharCRM\Bundle\CoreBundle\Enum\DNCStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\LeadContactStatus;

#use Symfony\Component\Validator\ExecutionContext;
use Symfony\Component\Validator\ExecutionContext;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ContactCard
 */
class ContactCard
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $networkType;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @var integer
     */
    private $type;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $contacts;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contacts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set networkType
     *
     * @param integer $networkType
     * @return ContactCard
     */
    public function setNetworkType($networkType)
    {
        $this->networkType = $networkType;

        return $this;
    }

    /**
     * Get networkType
     *
     * @return integer
     */
    public function getNetworkType()
    {
        return $this->networkType;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return ContactCard
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ContactCard
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return ContactCard
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Add contacts
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Contact $contacts
     * @return ContactCard
     */
    public function addContact(\ZesharCRM\Bundle\CoreBundle\Entity\Contact $contacts)
    {
        $this->contacts[] = $contacts;

        return $this;
    }

    /**
     * Remove contacts
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Contact $contacts
     */
    public function removeContact(\ZesharCRM\Bundle\CoreBundle\Entity\Contact $contacts)
    {
        $this->contacts->removeElement($contacts);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContacts()
    {
        return $this->contacts;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $relatedLeads;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $relatedOpportunities;


    /**
     * Add relatedLeads
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Lead $relatedLeads
     * @return ContactCard
     */
    public function addRelatedLead(\ZesharCRM\Bundle\CoreBundle\Entity\Lead $relatedLeads)
    {
        $this->relatedLeads[] = $relatedLeads;

        return $this;
    }

    /**
     * Remove relatedLeads
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Lead $relatedLeads
     */
    public function removeRelatedLead(\ZesharCRM\Bundle\CoreBundle\Entity\Lead $relatedLeads)
    {
        $this->relatedLeads->removeElement($relatedLeads);
    }

    /**
     * Get relatedLeads
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRelatedLeads()
    {
        return $this->relatedLeads;
    }

    /**
     * Add relatedOpportunities
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Opportunity $relatedOpportunities
     * @return ContactCard
     */
    public function addRelatedOpportunity(\ZesharCRM\Bundle\CoreBundle\Entity\Opportunity $relatedOpportunities)
    {
        $this->relatedOpportunities[] = $relatedOpportunities;

        return $this;
    }

    /**
     * Remove relatedOpportunities
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Opportunity $relatedOpportunities
     */
    public function removeRelatedOpportunity(\ZesharCRM\Bundle\CoreBundle\Entity\Opportunity $relatedOpportunities)
    {
        $this->relatedOpportunities->removeElement($relatedOpportunities);
    }

    /**
     * Get relatedOpportunities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRelatedOpportunities()
    {
        return $this->relatedOpportunities;
    }

    public function __toString() {
        $string = $this->getFirstName() . ' ';
        if ($middleInitial = $this->getMiddleInitial()) {
            $string .= $middleInitial . ' ';
        }
        $string .= $this->getLastName() . ' ';
        if ($phone = $this->getPhone()) {
            $string .= '(' . $phone . ')';
        }

        return $string;
    }
    
    /**
     * @var string
     */
    private $streetAddress;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $zip;


    /**
     * Set streetAddress
     *
     * @param string $streetAddress
     * @return ContactCard
     */
    public function setStreetAddress($streetAddress)
    {
        $this->streetAddress = $streetAddress;

        return $this;
    }

    /**
     * Get streetAddress
     *
     * @return string 
     */
    public function getStreetAddress()
    {
        return $this->streetAddress;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return ContactCard
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return ContactCard
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set zip
     *
     * @param string $zip
     * @return ContactCard
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string 
     */
    public function getZip()
    {
        return $this->zip;
    }
    
    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    private $isOpportunity;

    /**
     * @param mixed $isOpportunity
     */
    public function setIsOpportunity($isOpportunity)
    {
        $this->isOpportunity = $isOpportunity;
    }

    /**
     * @return mixed
     */
    public function getIsOpportunity()
    {
        return $this->isOpportunity;
    }

    /**
     * @var string
     */
    private $fullName;
    
    /**
     * @var string
     */
    private $middleInitial;

    private $other;

    
    public function getMiddleInitial()
    {
        return $this->middleInitial;
    }

    public function setMiddleInitial($middleInitial)
    {
        $this->middleInitial = $middleInitial;
        return $this;
    }

    
    /**
     * Set firstName
     *
     * @param string $firstName
     * @return ContactCard
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return ContactCard
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    
    private function getContactByType($type)
    {
        foreach ($this->getContacts() as $contact) {
            if ($type == $contact->getType() && $contact->getIsDefault()) {
                return $contact;
            }
        }
        return $this->getFirstMatchedContactByType($type);
    }
    
    private function getFirstMatchedContactByType($type)
    {
        foreach ($this->getContacts() as $contact) {
            if ($type == $contact->getType()) {
                return $contact;
            }
        }
        return NULL;
    }
    
    public function getPhone()
    {
        if ($phone = $this->getContactByType(ContactType::GENERIC_PHONE)) {
            return $phone;
        }
        if ($phone = $this->getContactByType(ContactType::CELL_PHONE)) {
            return $phone;
        }
        if ($phone = $this->getContactByType(ContactType::WORK_PHONE)) {
            return $phone;
        }
        return NULL;
    }
    
    public function getGenericPhone()
    {
        return $this->getContactByType(ContactType::GENERIC_PHONE);
    }
    
    public function getCellPhone()
    {
        return $this->getContactByType(ContactType::CELL_PHONE);
    }
    
    public function getWorkPhone()
    {
        return $this->getContactByType(ContactType::WORK_PHONE);
    }

    public function getEmail()
    {
        return $this->getContactByType(ContactType::EMAIL);
    }
    
    public function getSkype()
    {
        return $this->getContactByType(ContactType::SKYPE);
    }
    
    public function getTwitter()
    {
        return $this->getContactByType(ContactType::TWITTER);
    }
    
    public function getCustomContacts()
    {
        $contactsArray = array();
        
        foreach ($this->getContacts() as $contact) {
            if (ContactType::CUSTOM === $contact->getType()) {
                $contactsArray[] = $contact;
            }
        }
        
        return $contactsArray;
    }
    
    public function getCustomContactsString()
    {
        $output = '';
        
        foreach ($this->getCustomContacts() as $contact) {
            $output .= $contact->getName() . ': ' . $contact->getValue() . "\n";
        }
        
        $output .= '';
        
        return $output;
    }
    
    public function getCallStatusString()
    {
        $phone = $this->getPhone();
        if (!$phone) {
            return NULL;
        }
        $mapping = LeadContactStatus::getHumanTitlesMap();
        return isset($mapping[$phone->getDonotCall()]) ? $mapping[$phone->getDonotCall()] : '';
    }
    
    public function getFullName() {
        $output = '';
        
        if ($firstName = $this->getFirstName()) {
            $output .= $firstName;
        }
        
        if ($middleInitial = $this->getMiddleInitial()) {
            $output .= ' ' . $middleInitial;
        }
        
        if ($lastName = $this->getLastName()) {
            $output .= ' ' . $lastName;
        }
        
        return $output;
    }

    public function getTypeString() {
        $mapping = ContactCardType::getHumanTitlesMap();
        return isset($mapping[$this->getType()]) ? $mapping[$this->getType()] : '';
    }

    public function getTypeStringWithNetworkType() {
        $mapping = ContactCardType::getHumanTitlesMap();
        $mappingNetwork = ContactCardNetworkType::getHumanTitlesMap();
        if ($this->getType() == ContactCardType::RNS) {
            $networkType = isset($mappingNetwork[$this->getNetworkType()]) ? ' ' . $mappingNetwork[$this->getNetworkType()] : '';
            return ($mapping[$this->getType()] . $networkType);
        } else {
            return isset($mapping[$this->getType()]) ? $mapping[$this->getType()] : '';
        }
    }

    public function getNetworkTypeString() {
        $mapping = ContactCardNetworkType::getHumanTitlesMap();
        return isset($mapping[$this->getNetworkType()]) ? $mapping[$this->getNetworkType()] : '';
    }

    /**
     * @param mixed $other
     */
    public function setOther($other)
    {
        $this->other = $other;
    }

    /**
     * @return mixed
     */
    public function getOther()
    {
        return $this->other;
    }


    public function __clone() {
        if ($this->id) {
            $this->id = null;
            if($this->contacts){
                $set = new ArrayCollection();
                foreach($this->contacts as $contact){
                    $set->add(clone $contact);
                }
                $this->contacts = $set;
            }

        }
    }
    public function zipCodeValidation(ExecutionContext $context)
    {
        $state = $this->getState();
        $zipCode = $this->getZip();

        if (strlen($state)==0) {
            $context->addViolation('Please, choose city from the list.');
        }

        if (!preg_match("/^([0-9]{5})(-[0-9]{4})?$/i",$zipCode)) {
            $context->addViolation('Zip code doesn\'t match.');
        }
    }

    
}
