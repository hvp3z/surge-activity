<?php


namespace ZesharCRM\Bundle\CoreBundle\Entity;

use ZesharCRM\Bundle\CoreBundle\Enum\LeadType;
use ZesharCRM\Bundle\CoreBundle\Enum\DealStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\LeadSubjectType;


abstract class LeadSubject implements LeadSubjectInterface/*, DateRangeInterface*/ {

    const MAIL_STATUS_STRING_YES = 'OK to Mail';
    const MAIL_STATUS_STRING_NO = 'Do Not Mail';
    const CALL_STATUS_STRING_YES = 'OK to Call';
    const CALL_STATUS_STRING_NO = 'Do Not Call';
    const COMMENT_FROM = 'From Lead to';
    const DATE_FIELD = 'updated_at';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $callReports;

    /**
     * @var string
     */
    protected $name;

    protected $scoring;

    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\LeadType
     */
    protected $leadType;

    /**
     * @var integer
     */
    protected $systemLeadType;

    /**
     * @var integer
     */
    protected $status;

    /**
     * @var boolean
     */
    protected $isArchive;

    /**
     * @var \DateTime
     */
    protected $deletedAt;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    protected $newAttachment;

    protected $newAttachmentFile;

    /**
     *  @var \Doctrine\Common\Collections\Collection
     */
    protected $prequalificationAutos;

    /**
     *  @var \Doctrine\Common\Collections\Collection
     */
    protected $prequalificationDrivers;

    /**
     *  @var \Doctrine\Common\Collections\Collection
     */
    protected $prequalificationInsuredAddresses;

    /**
     * @var \DateTime
     */
    protected $previousCarrierXDate;

    /**
     * @var string
     */
    protected $previousCarrierPolice;

    /**
     * @var string
     */
    protected $previousCarrierName;

    /**
     *  @var \Doctrine\Common\Collections\Collection
     */
    protected $operations;

    /**
     *  @var \Doctrine\Common\Collections\Collection
     */
    protected $milestoneOperations;

    protected $contactCardOpportunity;

        /**
     * @var integer
     */
    private $quantity;

        /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\ContactCard
     */
    protected $contactCard;

    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\Opportunity
     */
    protected $opportunity;

        /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\LeadCategory
     */
    protected $leadCategory;
    
        /**
     * @var \DateTime
     */
    protected $purchasedAt;

    /**
     * @var integer
     */
    protected $purchaseAmount;

    /**
     * @var integer
     */
    protected $estimatedValue;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $attachments;

    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\Activity
     */
    protected $leadCampaign;

    protected $leadSource;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $leadEvents;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attachments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->operations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->milestoneOperations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @param mixed $contactCardOpportunity
     */
    public function setContactCardOpportunity($contactCardOpportunity)
    {
        $this->contactCardOpportunity = $contactCardOpportunity;
        $contactCardOpportunity->setIsOpportunity(1);
    }

    /**
     * @return mixed
     */
    public function getContactCardOpportunity()
    {
        return $this->contactCardOpportunity;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Lead
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set isArchive
     *
     * @param boolean $isArchive
     * @return Lead
     */
    public function setIsArchive($isArchive)
    {
        $this->isArchive = $isArchive;

        return $this;
    }

    /**
     * Get isArchive
     *
     * @return boolean
     */
    public function getIsArchive()
    {
        return $this->isArchive;
    }

    /**
     * Set leadType
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadType $leadType
     * @return Lead
     */
    public function setLeadType($leadType)
    {
        $this->leadType = $leadType;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set deletedAt
     *
     * @return \DateTime $deletedAt
     * @return Lead
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get leadType
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\LeadType
     */
    public function getLeadType()
    {
        return $this->leadType;
    }

    /**
     * Set systemLeadType
     *
     * @param integer $systemLeadType
     * @return Lead
     */
    public function setSystemLeadType($systemLeadType)
    {
        $this->systemLeadType = $systemLeadType;

        return $this;
    }

    /**
     * Get systemLeadType
     *
     * @return integer
     */
    public function getSystemLeadType()
    {
        return $this->systemLeadType;
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
     * @return Lead
     */
    public function setPreviousCarrierPolice($previousCarrierPolice)
    {
        $this->previousCarrierPolice = $previousCarrierPolice;

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
     * Set previousCarrierXDate
     *
     * @param \DateTime $previousCarrierXDate
     * @return Lead
     */
    public function setPreviousCarrierXDate($previousCarrierXDate)
    {
        $this->previousCarrierXDate = $previousCarrierXDate;

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
     * @return Lead
     */
    public function setPreviousCarierName($previousCarrierName)
    {
        $this->previousCarrierName = $previousCarrierName;

        return $this;
    }

    /**
     * Add prequalificationInsuredAddress
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadPrequalificationInsuredAddress $prequalificationInsuredAddress
     * @return Lead
     */
    public function addPrequalificationInsuredAddress($prequalificationInsuredAddress)
    {
        $this->prequalificationInsuredAddresses[] = $prequalificationInsuredAddress;

        return $this;
    }

    public function setPrequalificationInsuredAddresses($prequalificationInsuredAddresses)
    {
        $this->prequalificationInsuredAddresses = $prequalificationInsuredAddresses;

        return $this;
    }

    /**
     * Get prequalificationInsuredAddresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrequalificationInsuredAddresses()
    {
        return $this->prequalificationInsuredAddresses;
    }

    /**
     * Remove prequalificationInsuredAddress
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadPrequalificationInsuredAddress $prequalificationInsuredAddress
     */
    public function removePrequalificationInsuredAddress(\ZesharCRM\Bundle\CoreBundle\Entity\LeadPrequalificationInsuredAddress $prequalificationInsuredAddress)
    {
        $this->prequalificationInsuredAddresses->removeElement($prequalificationInsuredAddress);
    }

    /**
     * Add prequalificationDriver
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadPrequalificationDriver $prequalificationDriver
     * @return Lead
     */
    public function addPrequalificationDriver($prequalificationDriver)
    {
        $this->prequalificationDrivers[] = $prequalificationDriver;

        return $this;
    }

    public function setPrequalificationDrivers($prequalificationDrivers)
    {
        $this->prequalificationDrivers = $prequalificationDrivers;

        return $this;
    }

    /**
     * Get prequalificationDrivers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrequalificationDrivers()
    {
        return $this->prequalificationDrivers;
    }

    /**
     * Remove prequalificationDriver
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadPrequalificationDriver $prequalificationDriver
     */
    public function removePrequalificationDriver(\ZesharCRM\Bundle\CoreBundle\Entity\LeadPrequalificationDriver $prequalificationDriver)
    {
        $this->prequalificationInsuredAddresses->removeElement($prequalificationDriver);
    }

    /**
     * Add prequalificationAuto
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadPrequalificationAuto $prequalificationAuto
     * @return Lead
     */
    public function addPrequalificationAuto($prequalificationAuto)
    {
        $this->prequalificationAutos[] = $prequalificationAuto;

        return $this;
    }

    public function setPrequalificationAutos($prequalificationAutos)
    {
        $this->prequalificationAutos = $prequalificationAutos;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrequalificationAutos()
    {
        return $this->prequalificationAutos;
    }

    /**
     * Remove prequalificationAuto
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadPrequalificationAuto $prequalificationAuto
     */
    public function removePrequalificationAuto(\ZesharCRM\Bundle\CoreBundle\Entity\LeadPrequalificationAuto $prequalificationAuto)
    {
        $this->prequalificationInsuredAddresses->removeElement($prequalificationAuto);
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
     * Set name
     *
     * @param string $name
     * @return Lead
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
     * Set status
     *
     * @param integer $status
     * @return Lead
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Lead
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Lead
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set contactCard
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\ContactCard $contactCard
     * @return Lead
     */
    public function setContactCard(\ZesharCRM\Bundle\CoreBundle\Entity\ContactCard $contactCard = null)
    {
        $this->contactCard = $contactCard;

        return $this;
    }

    /**
     * Get contactCard
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\ContactCard
     */
    public function getContactCard()
    {
        return $this->contactCard;
    }

    /**
     * Set opportunity
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Opportunity $opportunity
     * @return Lead
     */
    public function setOpportunity(\ZesharCRM\Bundle\CoreBundle\Entity\Opportunity $opportunity = null)
    {
        $this->opportunity = $opportunity;

        return $this;
    }

    /**
     * Get opportunity
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\Opportunity
     */
    public function getOpportunity()
    {
        return $this->opportunity;
    }

    public function getTypeString() {
        $mapping = LeadType::getHumanTitlesMap();
        return isset($mapping[$this->getType()]) ? $mapping[$this->getType()] : '';
    }

    public function getSystemTypeString() {
        $mapping = LeadSubjectType::getHumanTitlesMap();
        return isset($mapping[$this->getSystemLeadType()]) ? $mapping[$this->getSystemLeadType()] : '';
    }

    public function getStatusString() {
        $mapping = DealStatus::getHumanTitlesMap();
        return isset($mapping[$this->getStatus()]) ? $mapping[$this->getStatus()] : '';
    }

    public function __toString() {
        return $this->getName();
    }

    /**
     * Set leadCategory
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadCategory $leadCategory
     * @return Lead
     */
    public function setLeadCategory(\ZesharCRM\Bundle\CoreBundle\Entity\LeadCategory $leadCategory = null)
    {
        $this->leadCategory = $leadCategory;

        return $this;
    }

    /**
     * Get leadCategory
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\LeadCategory
     */
    public function getLeadCategory()
    {
        return $this->leadCategory;
    }

//    public function getMailStatusString()
//    {
//        return $this->getMailStatus() ? self::MAIL_STATUS_STRING_YES : self::MAIL_STATUS_STRING_NO;
//    }

    /**
     * Set purchasedAt
     *
     * @param \DateTime $purchasedAt
     * @return Lead
     */
    public function setPurchasedAt($purchasedAt)
    {
        $this->purchasedAt = $purchasedAt;

        return $this;
    }

    /**
     * Get purchasedAt
     *
     * @return \DateTime
     */
    public function getPurchasedAt()
    {
        return $this->purchasedAt;
    }

    /**
     * Set purchaseAmount
     *
     * @param integer $purchaseAmount
     * @return Lead
     */
    public function setPurchaseAmount($purchaseAmount)
    {
        $this->purchaseAmount = $purchaseAmount;

        return $this;
    }

    /**
     * Get purchaseAmount
     *
     * @return integer
     */
    public function getPurchaseAmount()
    {
        return $this->purchaseAmount;
    }

    /**
     * Set estimatedValue
     *
     * @param integer $estimatedValue
     * @return Lead
     */
    public function setEstimatedValue($estimatedValue)
    {
        $this->estimatedValue = $estimatedValue;

        return $this;
    }

    /**
     * Get estimatedValue
     *
     * @return integer
     */
    public function getEstimatedValue()
    {
        return $this->estimatedValue;
    }

    /**
     * Add attachments
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadAttachment $attachments
     * @return Lead
     */
//    public function addAttachment(\ZesharCRM\Bundle\CoreBundle\Entity\LeadAttachment $attachments)
//    {
//        $this->attachments[] = $attachments;
//
//        return $this;
//    }

    /**
     * Remove attachments
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadAttachment $attachments
     */
//    public function removeAttachment(\ZesharCRM\Bundle\CoreBundle\Entity\LeadAttachment $attachments)
//    {
//        $this->attachments->removeElement($attachments);
//    }

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

    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;
        return $this;
    }

    /**
     * Get leadCampaign
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\Activity
     */
    public function getLeadCampaign()
    {
        return $this->leadCampaign;
    }

    /**
     * Set leadCampaign
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Activity $leadCampaign
     * @return LeadSubject
     */
    public function setLeadCampaign($leadCampaign)
    {
        $this->leadCampaign = $leadCampaign;
        return $this;
    }

    public function getLeadSource()
    {
        return $this->leadSource;
    }

    public function setLeadSource($leadSource)
    {
        $this->leadSource = $leadSource;
        return $this;
    }

    /**
     * Add leadEvents
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadEvent $leadEvents
     * @return Lead
     */
    public function addLeadEvent(\ZesharCRM\Bundle\CoreBundle\Entity\LeadEvent $leadEvents)
    {
        $this->leadEvents[] = $leadEvents;

        return $this;
    }

    public function setLeadEvents($leadEvents)
    {
        $this->leadEvents = $leadEvents;

        return $this;
    }

    /**
     * Remove leadEvents
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadEvent $leadEvents
     */
    public function removeLeadEvent(\ZesharCRM\Bundle\CoreBundle\Entity\LeadEvent $leadEvents)
    {
        $this->leadEvents->removeElement($leadEvents);
    }

    /**
     * Get leadEvents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLeadEvents()
    {
        return $this->leadEvents;
    }

    /**
     * Add operation
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Operation $operation
     * @return Lead
     */
    public function addOperation($operation)
    {
        $this->operations[] = $operation;

        return $this;
    }

    /**
     * Add milestoneOperation
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\MilestoneOperation $milestoneOperation
     * @return Lead
     */
    public function addMilestoneOperation(\ZesharCRM\Bundle\CoreBundle\Entity\MilestoneOperation $milestoneOperation)
    {
        $this->milestoneOperations[] = $milestoneOperation;

        return $this;
    }

    /**
     * Get operations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOperations()
    {
        return $this->operations;
    }

    /**
     * Get milestoneOperations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMilestoneOperations()
    {
        return $this->milestoneOperations;
    }

    /**
     * Remove operation
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Operation $operation
     */
    public function removeOperation(\ZesharCRM\Bundle\CoreBundle\Entity\Operation $operation)
    {
        $this->operations->removeElement($operation);
    }

    /**
     * Remove milestoneOperation
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\MilestoneOperation $milestoneOperation
     */
    public function removeMilestoneOperation(\ZesharCRM\Bundle\CoreBundle\Entity\MilestoneOperation $milestoneOperation)
    {
        $this->milestoneOperations->removeElement($milestoneOperation);
    }

    protected function updateLink($entities, $link){
        foreach($entities as $entity){
            if(method_exists($entity, 'setLead')){
                var_dump($entity->getId());
                $entity->setLead($link);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getScoring()
    {
        return $this->scoring;
    }

    /**
     * @param mixed $scoring
     */
    public function setScoring($scoring)
    {
        $this->scoring = $scoring;
    }

    public function getDateField()
    {
        return self::DATE_FIELD;
    }

    /**
     * Add callReports
     *
     * @param \ZesharCRM\Bundle\CallsBundle\Entity\CallReporting $callReports
     * @return LeadSubject
     */
    public function addCallReports(\ZesharCRM\Bundle\CallsBundle\Entity\CallReporting $callReports)
    {
        $this->callReports[] = $callReports;

        return $this;
    }

    /**
     * Remove callReports
     *
     * @param \ZesharCRM\Bundle\CallsBundle\Entity\CallReporting $callReports
     */
    public function removeCallReports(\ZesharCRM\Bundle\CallsBundle\Entity\CallReporting $callReports)
    {
        $this->callReports->removeElement($callReports);
    }

    /**
     * Get callReports
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCallReport()
    {
        return $this->callReports;
    }
} 