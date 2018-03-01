<?php

namespace ZesharCRM\Bundle\CallsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ZesharCRM\Bundle\CallsBundle\Enum\CallReportingType;
use ZesharCRM\Bundle\CallsBundle\Enum\CallReportingStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\ContactType;

/**
 * CallReporting
 */
class CallReporting
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $startsAt;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var integer
     */
    private $assignee;

    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\Contact
     */
    private $contact;

    /**
     * @var integer
     */
    private $eventsType;

    /**
     * @var integer
     */
    private $lead;

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
     * Set startsAt
     *
     * @param \DateTime $startsAt
     * @return CallReporting
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
     * Set status
     *
     * @param integer $status
     * @return CallReporting
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
     * Set type
     *
     * @param integer $type
     * @return CallReporting
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
     * Set contact
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Contact $contact
     * @return CallReporting
     */
    public function setContact(\ZesharCRM\Bundle\CoreBundle\Entity\Contact $contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\Contact
     */
    public function getContact()
    {
        return $this->contact;
    }

    public function getTypeString() {
        $mapping = CallReportingType::getHumanTitlesMap();
        return isset($mapping[$this->getType()]) ? $mapping[$this->getType()] : '';
    }

    public function getStatusString() {
        $mapping = CallReportingStatus::getHumanTitlesMap();
        return isset($mapping[$this->getType()]) ? $mapping[$this->getStatus()] : '';
    }

    public function getEventsTypeString() {
        $mapping = ContactType::getHumanTitlesMapWide();
        return isset($mapping[$this->getEventsType()]) ? $mapping[$this->getEventsType()] : '';
    }

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $duration;

    /**
     * Set description
     *
     * @param string $description
     * @return CallReporting
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set duration
     *
     * @param \DateTime $duration
     * @return CallReporting
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return \DateTime 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set assignee
     *
     * @param integer $assignee
     * @return CallReporting
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
     * @param int $eventsType
     */
    public function setEventsType($eventsType)
    {
        $this->eventsType = $eventsType;
    }

    /**
     * @return int
     */
    public function getEventsType()
    {
        return $this->eventsType;
    }

    /**
     * @param int $lead
     */
    public function setLead($lead)
    {
        $this->lead = $lead;
    }

    /**
     * @return int
     */
    public function getLead()
    {
        return $this->lead;
    }


}