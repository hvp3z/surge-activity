<?php

namespace ZesharCRM\Bundle\LeadScoringBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LeadScoring
 */
class LeadScoring
{
   
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $scoring;

    /**
     * @var integer
     */
    private $total;

    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\Opportunity
     */
    private $opportunity;

    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\Lead
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
     * Set scoring
     *
     * @param string $scoring
     * @return LeadScoring
     */
    public function setScoring($scoring)
    {
        $this->scoring = $scoring;

        return $this;
    }

    /**
     * Get scoring
     *
     * @return string 
     */
    public function getScoring()
    {
        return $this->scoring;
    }

    /**
     * Set total
     *
     * @param integer $total
     * @return LeadScoring
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
     * Set opportunity
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Opportunity $opportunity
     * @return LeadScoring
     */
    public function setOpportunity(\ZesharCRM\Bundle\CoreBundle\Entity\Opportunity $opportunity = null)
    {
        $this->opportunity = $opportunity;

        return $this;
    }

    /**
     * Get opportunity
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\Opportunity 
     */
    public function getOpportunity()
    {
        return $this->opportunity;
    }

    /**
     * Set lead
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Lead $lead
     * @return LeadScoring
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
}
