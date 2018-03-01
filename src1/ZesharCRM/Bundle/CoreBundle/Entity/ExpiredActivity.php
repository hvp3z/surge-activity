<?php

namespace ZesharCRM\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use ZesharCRM\Bundle\CoreBundle\Enum\ActivityType;

/**
 * ExpiredActivity
 */
class ExpiredActivity
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
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $startsAt;

    /**
     * @var \DateTime
     */
    private $finishesAt;

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
     * Add lead
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject $lead
     * @return ExpiredActivity
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
     * @return ExpiredActivity
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
     * Set description
     *
     * @param string $description
     * @return ExpiredActivity
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
     * Set startsAt
     *
     * @param \DateTime $startsAt
     * @return ExpiredActivity
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
     * @return ExpiredActivity
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
     * @return ExpiredActivity
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
     * @return ExpiredActivity
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
     * @return ExpiredActivity
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
     * @return ExpiredActivity
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
        return $this->getTitle();
    }
}

