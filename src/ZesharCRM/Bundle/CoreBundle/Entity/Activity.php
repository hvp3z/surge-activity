<?php

namespace ZesharCRM\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ZesharCRM\Bundle\CoreBundle\Enum\ActivityType;
use ZesharCRM\Bundle\CoreBundle\Enum\ActivityFrequency;
use ZesharCRM\Bundle\CoreBundle\Enum\DealStatus;
/**
 * Activity
 */
class Activity implements AccessInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;


    /**
     * @var \DateTime
     */
    private $startsAt;

    /**
     * @var \DateTime
     */
    private $finishesAt;

    /**
     * @var \DateTime
     */
    private $startTime;

    /**
     * @var \DateTime
     */
    private $endTime;

    /**
     * @var integer
     */
    private $creator;

    /**
     * @var integer
     */
    private $assignee;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var string
     */
    private $customType;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $lead;

    /**
     * @var integer
     */
    private $quantity;


    /**
     * @var integer
     */
    private $frequency;

    /**
     * @var \DateTime
     */
    private $slot;

    /**
     * @var string
     */
    private $slotString;

    /*
     * Dependency injection
     */

    /**
     * Add lead
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject $lead
     * @return Activity
     */
    public function addLead(\ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject $lead)
    {
        $this->lead[] = $lead;

        return $this;
    }

    /**
     * Remove lead
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject $lead
     */
    public function removeLead(\ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject $lead)
    {
        $this->lead->removeElement($lead);
    }

    /**
     * Get lead
     *
     * @return \Doctrine\Common\Collections\Collection
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
     * Set title
     *
     * @param string $title
     * @return Activity
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set startsAt
     *
     * @param \DateTime $startsAt
     * @return Activity
     */
    public function setStartsAt($startsAt)
    {
        $this->startsAt = $startsAt;

        return $this;
    }

    /**
     * Get startsAt
     *
     * @return \DateTime 
     */
    public function getStartsAt()
    {
        return $this->startsAt;
    }

    /**
     * Set finishesAt
     *
     * @param \DateTime $finishesAt
     * @return Activity
     */
    public function setFinishesAt($finishesAt)
    {
        $this->finishesAt = $finishesAt;

        return $this;
    }

    /**
     * Get finishesAt
     *
     * @return \DateTime 
     */
    public function getFinishesAt()
    {
        return $this->finishesAt;
    }

    /**
     * Set creator
     *
     * @param integer $creator
     * @return Activity
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return integer 
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set assignee
     *
     * @param integer $assignee
     * @return Activity
     */
    public function setAssignee($assignee)
    {
        $this->assignee = $assignee;

        return $this;
    }

    /**
     * Get assignee
     *
     * @return integer 
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Activity
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
     * Set customType
     *
     * @param string $customType
     * @return Activity
     */
    public function setCustomType($customType)
    {
        $this->customType = $customType;

        return $this;
    }

    /**
     * Get customType
     *
     * @return string 
     */
    public function getCustomType()
    {
        return $this->customType;
    }

    public function getTypeString() {
        $mapping = ActivityType::getHumanTitlesMap();
        return isset($mapping[$this->getType()]) ? $mapping[$this->getType()] : '';
    }

    public function __toString() {
        try {
            return (string) $this->getTitle();
        } catch (Exception $exception) {
            return '';
        }
    }

    /**
     * @param \DateTime $endTime
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    /**
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    private $frequenceString;

    public function getFrequencyString()
    {
        $mapping = ActivityFrequency::getHumanTitlesMap();
        return isset($mapping[$this->getFrequency()]) ? $mapping[$this->getFrequency()] : '';
    }

    /**
     * @param int $frequency
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;
    }

    /**
     * @return int
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->getActiveLeadsCount();
    }

    /**
     * @param \DateTime $startTime
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param \DateTime $slot
     */
    public function setSlot($slot)
    {
        $this->slot = $slot;
    }

    /**
     * @return \DateTime
     */
    public function getSlot()
    {
        return $this->slot;
    }

    /**
     * @param string $slotString
     */
    public function setSlotString($slotString)
    {
        $this->slotString = $slotString;
    }

    /**
     * @return string
     */
    public function getSlotString()
    {
        return $this->slotString;
    }

    private function getActiveLeadsCount()
    {
        $leads = $this->getLead();
        $activeLeadsCount = 0;
        if(!empty($leads)){
            /** @var $lead Lead */
            foreach($leads as $key=>$lead){
                $leadType = get_class($lead);
                $createdAt = $lead->getCreatedAt();
                $updatedAt = $lead->getUpdatedAt();
                $leadCategory = $lead->getLeadCategory();
                $status = $lead->getStatus();

                if((($leadType == 'ZesharCRM\Bundle\CoreBundle\Entity\Lead' && $leadCategory)
                    || $createdAt != $updatedAt)
                ){
                    if(($lead->getStatus() == DealStatus::PENDING)){
                        $activeLeadsCount++;
                    }
                }
            }
        }
        return $activeLeadsCount;
    }
}