<?php

namespace ZesharCRM\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OpportunityAttachment
 */
class OpportunityAttachment
{
    /**
     * @var integer
     */
    private $id;


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
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\Attachment
     */
    private $attachment;

    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\Opportunity
     */
    private $opportunity;


    /**
     * Set attachment
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Attachment $attachment
     * @return LeadAttachment
     */
    public function setAttachment(\ZesharCRM\Bundle\CoreBundle\Entity\Attachment $attachment = null)
    {
        $this->attachment = $attachment;

        return $this;
    }

    /**
     * Get attachment
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\Attachment 
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * Set lead
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Lead $lead
     * @return LeadAttachment
     */
    public function setOpportunity(\ZesharCRM\Bundle\CoreBundle\Entity\Opportunity $opportunity)
    {
        $this->opportunity = $opportunity;

        return $this;
    }

    /**
     * Get lead
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\Opportunity 
     */
    public function getOpportunity()
    {
        return $this->opportunity;
    }
    
}
