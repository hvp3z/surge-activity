<?php

namespace ZesharCRM\Bundle\GoalsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ZesharCRM\Bundle\CoreBundle\Enum\GoalKind;

/**
 * Goal
 */
class Goal
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $creator;

    /**
     * @var float
     */
    private $estimated;

    /**
     * @var string
     */
    private $title = 'Goal';

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
     * Set description
     *
     * @param string $description
     * @return Goal
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
     * Set creator
     *
     * @param integer $creator
     * @return Goal
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
     * Set estimated
     *
     * @param float $estimated
     * @return Goal
     */
    public function setEstimated($estimated)
    {
        $this->estimated = $estimated;

        return $this;
    }

    /**
     * Get estimated
     *
     * @return float
     */
    public function getEstimated()
    {
        return $this->estimated;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $assignments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->assignments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add assignments
     *
     * @param \ZesharCRM\Bundle\GoalsBundle\Entity\GoalAssignment $assignments
     * @return Goal
     */
    public function addAssignment(\ZesharCRM\Bundle\GoalsBundle\Entity\GoalAssignment $assignments)
    {
        $this->assignments[] = $assignments;

        return $this;
    }

    /**
     * Remove assignments
     *
     * @param \ZesharCRM\Bundle\GoalsBundle\Entity\GoalAssignment $assignments
     */
    public function removeAssignment(\ZesharCRM\Bundle\GoalsBundle\Entity\GoalAssignment $assignments)
    {
        $this->assignments->removeElement($assignments);
    }

    /**
     * Get assignments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAssignments()
    {
        return $this->assignments;
    }

    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\LeadCategory
     */
    private $goalCategory;


    /**
     * Set goalCategory
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadCategory $goalCategory
     * @return Goal
     */
    public function setGoalCategory(\ZesharCRM\Bundle\CoreBundle\Entity\LeadCategory $goalCategory)
    {
        $this->goalCategory = $goalCategory;

        return $this;
    }

    /**
     * Get goalCategory
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\LeadCategory
     */
    public function getGoalCategory()
    {
        return $this->goalCategory;
    }

    /**
     * @var integer
     */
    private $total;


    /**
     * Set total
     *
     * @param integer $total
     * @return Goal
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return integer 
     */
    public function getTotal()
    {
        return $this->total;
    }
    /**
     * @var \DateTime
     */
    private $startsAt;

    /**
     * @var \DateTime
     */
    private $finishesAt;

    /**
     * Set startsAt
     *
     * @param \DateTime $startsAt
     * @return Goal
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
     * @return Goal
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
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get title of the entity
     */
    public function __toString() {
        return (string) $this->getDescription();
    }
}