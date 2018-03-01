<?php

namespace ZesharCRM\Bundle\GoalsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GoalAssign
 */
class GoalAssign
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \ZesharCRM\Bundle\GoalsBundle\Entity\UserExtension
     */
    private $user;

    /**
     * @var \ZesharCRM\Bundle\GoalsBundle\Entity\Goal
     */
    private $goal;

    /**
     * @var float
     */
    private $point;

    /**
     * @var float
     */
    private $percent;

    /**
     * @var float
     */
    private $items;

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
     * Set user
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\User $user
     * @return GoalAssign
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set goal
     *
     * @param \ZesharCRM\Bundle\GoalsBundle\Entity\Goal $goal
     * @return GoalAssign
     */
    public function setGoal($goal)
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
     * Set point
     *
     * @param float $point
     * @return GoalAssign
     */
    public function setPoint($point)
    {
        $this->point = $point;

        return $this;
    }

    /**
     * Get point
     *
     * @return float
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * Set percent
     *
     * @param float $percent
     * @return GoalAssign
     */
    public function setPercent($percent)
    {
        $this->percent = $percent;

        return $this;
    }

    /**
     * Get percent
     *
     * @return float
     */
    public function getPercent()
    {
        return $this->percent;
    }

    /**
     * Set items
     *
     * @param float $items
     * @return GoalAssign
     */
    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Get items
     *
     * @return float
     */
    public function getItems()
    {
        return $this->items;
    }
}
