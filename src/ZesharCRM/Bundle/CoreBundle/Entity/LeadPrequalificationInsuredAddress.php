<?php

namespace ZesharCRM\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ZesharCRM\Bundle\CoreBundle\Enum\InsuredAddressType;

/**
 * LeadPrequalificationInsuredAddress
 */
class LeadPrequalificationInsuredAddress
{
    /**
     * @var integer
     */
    private $id;


    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $zipCode;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $previousCarrierName;

    /**
     * @var string
     */
    private $previousCarrierPolice;


    private $lead;

    /**
     * @var \DateTime
     */
    protected $previousCarrierXDate;

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
     * Set type
     *
     * @param integer $type
     * @return LeadPrequalificationInsuredAddress
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set previousCarrierXDate
     *
     * @param \DateTime $previousCarrierXDate
     * @return LeadPrequalificationInsuredAddress
     */
    public function setPreviousCarrierXDate($previousCarrierXDate)
    {
        $this->previousCarrierXDate = $previousCarrierXDate;

        return $this;
    }

    /**
     * Get previousCarrierXDate
     *
     * @return \DateTime
     */
    public function getPreviousCarrierXDate()
    {
        return $this->previousCarrierXDate;
    }

    /**
     * Set lead
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Lead $lead
     * @return LeadPrequalificationInsuredAddress
     */
    public function setLead($lead)
    {
        $this->lead = $lead;

        return $this;
    }

    /**
     * Get lead
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\Lead
     */
    public function getLead()
    {
        return $this->lead;
    }

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
 * Get city
 *
 * @return string
 */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return LeadPrequalificationInsuredAddress
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get previousCarrierPolice
     *
     * @return string
     */
    public function getPreviousCarrierPolice()
    {
        return $this->previousCarrierPolice;
    }

    /**
     * Set previousCarrierPolice
     *
     * @param string $previousCarrierPolice
     * @return LeadPrequalificationInsuredAddress
     */
    public function setPreviousCarrierPolice($previousCarrierPolice)
    {
        $this->previousCarrierPolice = $previousCarrierPolice;

        return $this;
    }

    /**
     * Get previousCarrierName
     *
     * @return string
     */
    public function getPreviousCarrierName()
    {
        return $this->previousCarrierName;
    }

    /**
     * Set previousCarrierName
     *
     * @param string $previousCarrierName
     * @return LeadPrequalificationInsuredAddress
     */
    public function setPreviousCarrierName($previousCarrierName)
    {
        $this->previousCarrierName = $previousCarrierName;

        return $this;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return LeadPrequalificationInsuredAddress
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return LeadPrequalificationInsuredAddress
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
     * Set zipCode
     *
     * @param string $zipCode
     * @return LeadPrequalificationInsuredAddress
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string 
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    public function getTypeString() {
        $mapping = InsuredAddressType::getHumanTitlesMap();
        return isset($mapping[$this->getType()]) ? $mapping[$this->getType()] : '';
    }
}
