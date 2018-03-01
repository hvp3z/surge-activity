<?php

namespace ZesharCRM\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ZesharCRM\Bundle\CoreBundle\Enum\EventGoal;

/**
 * LeadEvent
 */
class LeadEvent
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $happensAt;

    /**
     * @var string
     */
    private $location;

    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\LeadEventType
     */
    private $type;


    /**
     * @var integer
     */
    private $goal;

    /**
     * Set goal
     *
     * @param integer $goal
     * @return LeadEvent
     */
    public function setGoal($goal)
    {
        $this->goal = $goal;

        return $this;
    }

    /**
     * Get goal
     *
     * @return integer
     */
    public function getGoal()
    {
        return $this->goal;
    }

    /**
     * Set type
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadEventType $type
     * @return LeadEvent
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\LeadEventType
     */
    public function getType()
    {
        return $this->type;
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
     * Set happensAt
     *
     * @param \DateTime $happensAt
     * @return LeadEvent
     */
    public function setHappensAt($happensAt)
    {
        $this->happensAt = $happensAt;

        return $this;
    }

    /**
     * Get happensAt
     *
     * @return \DateTime 
     */
    public function getHappensAt()
    {
        return $this->happensAt;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return LeadEvent
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }
    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\Lead
     */
    private $lead;


    /**
     * Set lead
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Lead $lead
     * @return LeadEvent
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

    public function getGoalString() {
        $mapping = EventGoal::getHumanTitles();
        return isset($mapping[$this->getGoal()]) ? $mapping[$this->getGoal()] : '';
    }
}
