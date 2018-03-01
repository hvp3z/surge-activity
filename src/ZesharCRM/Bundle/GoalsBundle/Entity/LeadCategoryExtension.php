<?php

namespace ZesharCRM\Bundle\GoalsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use  ZesharCRM\Bundle\CoreBundle\Entity\LeadCategory as LeadCategory;
/**
 * LeadCategory
 */
class LeadCategoryExtension extends LeadCategory
{

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $goal;


    /**
     * Add goal
     *
     * @param \ZesharCRM\Bundle\GoalsBundle\Entity\Goal $goal
     * @return LeadCategory
     */
    public function addGoal(\ZesharCRM\Bundle\GoalsBundle\Entity\Goal $goal)
    {
        $this->goal[] = $goal;

        return $this;
    }

    /**
     * Remove goal
     *
     * @param \ZesharCRM\Bundle\GoalsBundle\Entity\Goal $goal
     */
    public function removeGoal(\ZesharCRM\Bundle\GoalsBundle\Entity\Goal $goal)
    {
        $this->goal->removeElement($goal);
    }

    /**
     * Get goal
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGoal()
    {
        return $this->goal;
    }

}
