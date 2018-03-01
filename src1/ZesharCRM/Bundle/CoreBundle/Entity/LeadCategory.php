<?php

namespace ZesharCRM\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LeadCategory
 */
class LeadCategory
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var float
     */
    private $average;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $lineCode;

    /**
     * @var string
     */
    private $lspValue;

    /**
     * @var integer
     */
    private $creator;

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
     * @return LeadCategory
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
     * Set lspValue
     *
     * @param string $lspValue
     * @return LeadCategory
     */
    public function setLspValue($lspValue)
    {
        $this->lspValue = $lspValue;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getLspValue()
    {
        return $this->lspValue;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $lead;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $opportunity;

//    /**
//     * @var \ZesharCRM\Bundle\GoalsBundle\Entity\Goal
//     */
//    private $goal;
//
//    /**
//     * Get goal
//     *
//     * @return \ZesharCRM\Bundle\GoalsBundle\Entity\Goal
//     */
//    public function getGoal()
//    {
//        return $this->goal;
//    }
//
//    /**
//     * Set goal
//     *
//     * @param \ZesharCRM\Bundle\GoalsBundle\Entity\Goal $goal
//     * @return LeadCategory
//     */
//    public function setGoal($goal)
//    {
//        $this->goal = $goal;
//
//        return $this;
//    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lead = new \Doctrine\Common\Collections\ArrayCollection();
        $this->opportunity = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add lead
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Lead $lead
     * @return LeadCategory
     */
    public function addLead(\ZesharCRM\Bundle\CoreBundle\Entity\Lead $lead)
    {
        $this->lead[] = $lead;

        return $this;
    }

    /**
     * Remove lead
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Lead $lead
     */
    public function removeLead(\ZesharCRM\Bundle\CoreBundle\Entity\Lead $lead)
    {
        $this->lead->removeElement($lead);
    }

    /**
     * Set lineCode
     *
     * @param string $lineCode
     * @return LeadCategory
     */
    public function setLineCode($lineCode)
    {
        $this->lineCode = $lineCode;

        return $this;
    }

    /**
     * Get lineCode
     *
     * @return string
     */
    public function getLineCode()
    {
        return $this->lineCode;
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
     * Add opportunity
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Opportunity $opportunity
     * @return LeadCategory
     */
    public function addOpportunity(\ZesharCRM\Bundle\CoreBundle\Entity\Opportunity $opportunity)
    {
        $this->opportunity[] = $opportunity;

        return $this;
    }

    /**
     * Remove opportunity
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Opportunity $opportunity
     */
    public function removeOpportunity(\ZesharCRM\Bundle\CoreBundle\Entity\Opportunity $opportunity)
    {
        $this->opportunity->removeElement($opportunity);
    }

    /**
     * Get opportunity
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOpportunity()
    {
        return $this->opportunity;
    }
    
    public function __toString() {
        return $this->getTitle();
    }

    /**
     * @var integer
     */
    private $effectiveDate;

    /**
     * @var integer
     */
    private $review;

    /**
     * @var integer
     */
    private $value;


    /**
     * Set effectiveDate
     *
     * @param integer $effectiveDate
     * @return LeadCategory
     */
    public function setEffectiveDate($effectiveDate)
    {
        $this->effectiveDate = $effectiveDate;

        return $this;
    }

    /**
     * Get effectiveDate
     *
     * @return integer 
     */
    public function getEffectiveDate()
    {
        return $this->effectiveDate;
    }

    /**
     * Set review
     *
     * @param integer $review
     * @return LeadCategory
     */
    public function setReview($review)
    {
        $this->review = $review;

        return $this;
    }

    /**
     * Get review
     *
     * @return integer 
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * Set average
     *
     * @param float $average
     * @return LeadCategory
     */
    public function setAverage($average)
    {
        $this->average = $average;

        return $this;
    }

    /**
     * Get average
     *
     * @return float
     */
    public function getAverage()
    {
        return $this->average;
    }

    /**
     * Set value
     *
     * @param integer $value
     * @return LeadCategory
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @var integer
     */
    private $points;


    /**
     * Set points
     *
     * @param integer $points
     * @return LeadCategory
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return integer 
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param int $creator
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    }

    /**
     * @return int
     */
    public function getCreator()
    {
        return $this->creator;
    }


}
