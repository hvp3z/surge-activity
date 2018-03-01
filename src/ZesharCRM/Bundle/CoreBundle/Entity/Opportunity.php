<?php

namespace ZesharCRM\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ZesharCRM\Bundle\CoreBundle\Enum\OpportunityStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\OpportunityPriority;

/**
 * Opportunity
 */
class Opportunity extends LeadSubject implements OpportunityInterface
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attachments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->operations = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function __toString()
    {
        return $this->getName() ?: '';
    }

    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\Lead
     */
    private $lead;

    /**
     * Set lead
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Lead $lead
     * @return Opportunity
     */
    public function setLead(\ZesharCRM\Bundle\CoreBundle\Entity\Lead $lead = null)
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
     * Assigns this opportunity to a user
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\User $assignee
     * @return Opportunity
     */
    public function assign(\ZesharCRM\Bundle\CoreBundle\Entity\User $assignee)
    {
        $this->setAssignee($assignee);
        return $this;
    }

    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\LeadCategory
     */
    private $opportunityCategory;
    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\User
     */
    private $creator;


    /**
     * Set creator
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\User $creator
     * @return Lead
     */
    public function setCreator(\ZesharCRM\Bundle\CoreBundle\Entity\User $creator = null)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\User
     */
    public function getCreator()
    {
        return $this->creator;
    }
    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\User
     */
    private $assignee;


    /**
     * Set assignee
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\User $assignee
     * @return Lead
     */
    public function setAssignee(\ZesharCRM\Bundle\CoreBundle\Entity\User $assignee = null)
    {
        $this->assignee = $assignee;

        return $this;
    }

    /**
     * Get assignee
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\User
     */
    public function getAssignee()
    {
        return $this->assignee;
    }


    /**
     * Set opportunityCategory
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadCategory $opportunityCategory
     * @return Opportunity
     */
    public function setOpportunityCategory( $opportunityCategory = NULL)
    {
//        $this->opportunityCategory = $opportunityCategory;
        $this->leadCategory = $opportunityCategory;

        return $this;
    }

    /**
     * Get opportunityCategory
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\LeadCategory 
     */
    public function getOpportunityCategory()
    {
        return $this->leadCategory;
    }

    public function getStatusString() {
        $mapping = OpportunityStatus::getHumanTitlesMap();
        return isset($mapping[$this->getStatus()]) ? $mapping[$this->getStatus()] : '';
    }
    /**
     * @var integer
     */
    private $price;

    /**
     * @var integer
     */
    private $priority;

    /**
     * @var integer
     */
    private $quotedAmount;

    /**
     * @var \DateTime
     */
    protected $closingDate;

    /**
     * @var \DateTime
     */
    protected $effectiveDate;

    /**
     * @var string
     */
    private $policyNumber;

    /**
     * @var string
     */
    private $effectiveDT;

    /**
     * @var string
     */
    private $lineCode;

    /**
     * @var string
     */
    private $lspCode;

    /**
     * @var string
     */
    private $renewalCount;

    /**
     * @var string
     */
    private $premium;

    /**
     * @var string
     */
    private $vehicleCount;

    /**
     * @var string
     */
    private $homeownersCount;

    /**
     * Get homeownersCount
     *
     * @return string
     */
    public function getHomeownersCount()
    {
        return $this->homeownersCount;
    }

    /**
     * Set homeownersCount
     *
     * @param string $homeownersCount
     * @return Opportunity
     */
    public function setHomeownersCount($homeownersCount)
    {
        $this->homeownersCount = $homeownersCount;

        return $this;
    }

    /**
     * Get lineCode
     *
     * @return string
     */
    public function getLineCode()
    {
        return $this->lineCode;
    }

    /**
     * Set lineCode
     *
     * @param string $lineCode
     * @return Opportunity
     */
    public function setLineCode($lineCode)
    {
        $this->lineCode = $lineCode;

        return $this;
    }

    /**
     * Get lspCode
     *
     * @return string
     */
    public function getLspCode()
    {
        return $this->lspCode;
    }

    /**
     * Set lspCode
     *
     * @param string $lspCode
     * @return Opportunity
     */
    public function setLspCode($lspCode)
    {
        $this->lspCode = $lspCode;

        return $this;
    }

    /**
     * Get premium
     *
     * @return string
     */
    public function getPremium()
    {
        return $this->premium;
    }

    /**
     * Set premium
     *
     * @param string $premium
     * @return Opportunity
     */
    public function setPremium($premium)
    {
        $this->premium = $premium;

        return $this;
    }

    /**
     * Get renewalCount
     *
     * @return string
     */
    public function getRenewalCount()
    {
        return $this->renewalCount;
    }

    /**
     * Set renewalCount
     *
     * @param string $renewalCount
     * @return Opportunity
     */
    public function setRenewalCount($renewalCount)
    {
        $this->renewalCount = $renewalCount;

        return $this;
    }

    /**
     * Get vehicleCount
     *
     * @return string
     */
    public function getVehicleCount()
    {
        return $this->vehicleCount;
    }

    /**
     * Set vehicleCount
     *
     * @param string $vehicleCount
     * @return Opportunity
     */
    public function setVehicleCount($vehicleCount)
    {
        $this->vehicleCount = $vehicleCount;

        return $this;
    }

    /**
     * Get policyNumber
     *
     * @return string
     */
    public function getPolicyNumber()
    {
        return $this->policyNumber;
    }

    /**
     * Set policyNumber
     *
     * @param string $policyNumber
     * @return Opportunity
     */
    public function setPolicyNumber($policyNumber)
    {
        $this->policyNumber = $policyNumber;

        return $this;
    }

    /**
     * Get policyNumber
     *
     * @return string
     */
    public function getEffectiveDT()
    {
        return $this->effectiveDT;
    }

    /**
     * Set effectiveDT
     *
     * @param string $effectiveDT
     * @return Opportunity
     */
    public function setEffectiveDT($effectiveDT)
    {
        $this->effectiveDT = $effectiveDT;

        return $this;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return Opportunity
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set priority
     *
     * @param integer $priority
     * @return Opportunity
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return integer
     */
    public function getPriority()
    {
        return $this->priority;
    }

    public function getPriorityString()
    {
        $mapping = OpportunityPriority::getHumanTitles();
        return isset($mapping[$this->getPriority()]) ? $mapping[$this->getPriority()] : '';
    }

    /**
     * Set quotedAmount
     *
     * @param integer $quotedAmount
     * @return Opportunity
     */
    public function setQuotedAmount($quotedAmount)
    {
        $this->quotedAmount = $quotedAmount;

        return $this;
    }

    /**
     * Get quotedAmount
     *
     * @return integer
     */
    public function getQuotedAmount()
    {
        return $this->quotedAmount;
    }

    /**
     * Set closingDate
     *
     * @param \DateTime $closingDate
     * @return Opportunity
     */
    public function setClosingDate($closingDate)
    {
        $this->closingDate = $closingDate;

        return $this;
    }

    /**
     * Get effectiveDate
     * Get effectiveDate
     *
     * @return \DateTime
     */
    public function getEffectiveDate()
    {
        return $this->effectiveDate;
    }

    /**
     * Set effectiveDate
     *
     * @param \DateTime $effectiveDate
     * @return Opportunity
     */
    public function setEffectiveDate($effectiveDate)
    {
        $this->effectiveDate = $effectiveDate;

        return $this;
    }

    /**
     * Get closingDate
     *
     * @return \DateTime
     */
    public function getClosingDate()
    {
        return $this->closingDate;
    }
    
    /**
     * Add attachments
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadAttachment $attachment
     * @return Opportunity
     */
    public function addAttachment(\ZesharCRM\Bundle\CoreBundle\Entity\LeadAttachment $attachment)
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    /**
     * Remove attachments
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\OpportunityAttachment $attachment
     */
    public function removeAttachment(\ZesharCRM\Bundle\CoreBundle\Entity\LeadAttachment $attachment)
    {
        $this->attachments->removeElement($attachment);
    }

    /**
     * Get attachments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAttachments()
    {
        return $this->attachments;
    }
    
    public function getNewAttachment() {
        return $this->newAttachment;
    }
    
    public function setNewAttachment($newAttachment)
    {
        $this->newAttachment = $newAttachment;
        return $this;
    }
    
    public function getNewAttachmentFile() {
        return $this->newAttachmentFile;
    }
    
    public function setNewAttachmentFile($newAttachmentFile)
    {
        $this->newAttachmentFile = $newAttachmentFile;
        return $this;
    }



    public function onLoadCallback(){
        if($this->lead){
            $lead = $this->lead;
            $this
              ->setPurchaseAmount($lead->getPurchaseAmount())
              ->setPurchasedAt($lead->getPurchasedAt())
              ->setEstimatedValue($lead->getEstimatedValue())
            ;

            if($lead->getPreviousCarrierXDate()){
                $this->setPreviousCarrierXDate($lead->getPreviousCarrierXDate());
            }

            if($lead->getPreviousCarrierPolice()){
                $this->setPreviousCarrierPolice($lead->getPreviousCarrierPolice());
            }

            if($lead->getContactCard()){
                $this->setContactCard($lead->getContactCard());
            }

            if($lead->getContactCardOpportunity()){
                $this->setContactCardOpportunity($lead->getContactCardOpportunity());
            }

            $this->setPrequalificationAutos($lead->getPrequalificationAutos());




            $this->setPrequalificationDrivers($lead->getPrequalificationDrivers());

            $this->setPrequalificationInsuredAddresses($lead->getPrequalificationInsuredAddresses());

            $this->setAttachments($lead->getAttachments());

            $this->setLeadEvents($lead->getLeadEvents());

        }
    }

    public function onUpdateCallback(){
        if($this->lead){
            $lead = $this->lead;
            $lead
              ->setContactCard($this->getContactCard())
              ->setPurchaseAmount($this->getPurchaseAmount())
              ->setPurchasedAt($this->getPurchasedAt())
              ->setEstimatedValue($this->getEstimatedValue())
              ->setPreviousCarierName($this->getPreviousCarrierName())
              ->setPreviousCarrierXDate($this->getPreviousCarrierXDate())
              ->setPreviousCarrierPolice($this->getPreviousCarrierPolice())
            ;
        }


    }



}
