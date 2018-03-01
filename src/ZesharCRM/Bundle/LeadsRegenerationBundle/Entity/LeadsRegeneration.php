<?php

namespace ZesharCRM\Bundle\LeadsRegenerationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LeadsRegeneration
 */
class LeadsRegeneration
{
   
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $regenerationAt;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $lead;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lead = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set regenerationAt
     *
     * @param \DateTime $regenerationAt
     * @return LeadsRegeneration
     */
    public function setRegenerationAt($regenerationAt)
    {
        $this->regenerationAt = $regenerationAt;

        return $this;
    }

    /**
     * Get regenerationAt
     *
     * @return \DateTime 
     */
    public function getRegenerationAt()
    {
        return $this->regenerationAt;
    }

    /**
     * Add lead
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Lead $lead
     * @return LeadsRegeneration
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
     * Get lead
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLead()
    {
        return $this->lead;
    }

    /**
     * Set lead
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Lead $lead
     * @return LeadsRegeneration
     */
    public function setLead(\ZesharCRM\Bundle\CoreBundle\Entity\Lead $lead = null)
    {
        $this->lead = $lead;

        return $this;
    }
}
