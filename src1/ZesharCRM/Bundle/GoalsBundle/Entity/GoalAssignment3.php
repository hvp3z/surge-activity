<?php

namespace ZesharCRM\Bundle\GoalsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ZesharCRM\Bundle\CoreBundle\Enum\GoalStatus;

/**
 * GoalAssignment
 */
class GoalAssignment3
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $goal;

    /**
     * @var integer
     */
    private $assignee;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $current;


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
     * Set goal
     *
     * @param integer $goal
     * @return GoalAssignment
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
     * Set assignee
     *
     * @param integer $assignee
     * @return GoalAssignment
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
     * Set status
     *
     * @param integer $status
     * @return GoalAssignment
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set current
     *
     * @param integer $current
     * @return GoalAssignment
     */
    public function setCurrent($current)
    {
        $this->current = $current;

        return $this;
    }

    /**
     * Get current
     *
     * @return integer 
     */
    public function getCurrent()
    {
        return $this->current;
    }

    public function getPercentComplete()
    {
        return $this->getPercent().'%';
    }

    public function getPercent()
    {
        return round($this->current/$this->getEstimated()*100);
    }

    public function getStatusString() {
        $mapping = GoalStatus::getHumanTitles();
        return isset($mapping[$this->getStatus()]) ? $mapping[$this->getStatus()] : '';
    }

    /**
     * @var integer
     */
    private $estimated;


    /**
     * Set estimated
     *
     * @param integer $estimated
     * @return GoalAssignment
     */
    public function setEstimated($estimated)
    {
        $this->estimated = $estimated;

        return $this;
    }

    /**
     * Get estimated
     *
     * @return integer 
     */
    public function getEstimated()
    {
        return $this->estimated;
    }
}
