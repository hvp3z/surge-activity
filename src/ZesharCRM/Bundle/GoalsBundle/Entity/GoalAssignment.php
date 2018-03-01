<?php

namespace ZesharCRM\Bundle\GoalsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ZesharCRM\Bundle\CoreBundle\Enum\GoalStatus;

/**
 * GoalAssignment
 */
class GoalAssignment
{
    
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $estimated;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $current;

    /**
     * @var \ZesharCRM\Bundle\GoalsBundle\Entity\Goal
     */
    private $goal;

    /**
     * @var \ZesharCRM\Bundle\GoalsBundle\Entity\UserExtension
     */
    private $assignee;


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
     * @return integer 
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

    /**
     * Set goal
     *
     * @param \ZesharCRM\Bundle\GoalsBundle\Entity\Goal $goal
     * @return GoalAssignment
     */
    public function setGoal(\ZesharCRM\Bundle\GoalsBundle\Entity\Goal $goal)
    {
        $this->goal = $goal;

        return $this;
    }

    /**
     * Get goal
     *
     * @return \ZesharCRM\Bundle\GoalsBundle\Entity\Goal 
     */
    public function getGoal()
    {
        return $this->goal;
    }

    /**
     * Set assignee
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\User $assignee
     * @return GoalAssignment
     */
    public function setAssignee(\ZesharCRM\Bundle\CoreBundle\Entity\User $assignee)
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

    public function getPercentComplete()
    {
        return 'Custom: '.$this->getPercent().'%';
    }

    public function getPercent()
    {
        if($this->getEstimated() != 0){
            $percentage = round($this->current/$this->getEstimated()*100);
        }else{
            $percentage = 0;
        }
        return $percentage;
    }

    public function getStatusString() {
        $mapping = GoalStatus::getHumanTitles();
        return isset($mapping[$this->getStatus()]) ? $mapping[$this->getStatus()] : '';
    }
}
