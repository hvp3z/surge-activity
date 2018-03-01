<?php

namespace ZesharCRM\Bundle\GoalsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ZesharCRM\Bundle\CoreBundle\Entity\User as User;

/**
 * Contact
 */
class UserExtension extends User
{
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $goalAssignments;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $createdGoals;
    
    /**
     * Add createdGoals
     *
     * @param \ZesharCRM\Bundle\GoalsBundle\Entity\Goal $createdGoals
     * @return User
     */
    public function addCreatedGoal(\ZesharCRM\Bundle\GoalsBundle\Entity\Goal $createdGoals)
    {
        $this->createdGoals[] = $createdGoals;

        return $this;
    }

    /**
     * Remove createdGoals
     *
     * @param \ZesharCRM\Bundle\GoalsBundle\Entity\Goal $createdGoals
     */
    public function removeCreatedGoal(\ZesharCRM\Bundle\GoalsBundle\Entity\Goal $createdGoals)
    {
        $this->createdGoals->removeElement($createdGoals);
    }

    /**
     * Get createdGoals
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCreatedGoals()
    {
        return $this->createdGoals;
    }

    /**
     * Add goalAssignments
     *
     * @param \ZesharCRM\Bundle\GoalsBundle\Entity\GoalAssignment $goalAssignments
     * @return User
     */
    public function addGoalAssignment(\ZesharCRM\Bundle\GoalsBundle\Entity\GoalAssignment $goalAssignments)
    {
        $this->goalAssignments[] = $goalAssignments;

        return $this;
    }

    /**
     * Remove goalAssignments
     *
     * @param \ZesharCRM\Bundle\GoalsBundle\Entity\GoalAssignment $goalAssignments
     */
    public function removeGoalAssignment(\ZesharCRM\Bundle\GoalsBundle\Entity\GoalAssignment $goalAssignments)
    {
        $this->goalAssignments->removeElement($goalAssignments);
    }

    /**
     * Get goalAssignments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGoalAssignments()
    {
        return $this->goalAssignments;
    }

}
