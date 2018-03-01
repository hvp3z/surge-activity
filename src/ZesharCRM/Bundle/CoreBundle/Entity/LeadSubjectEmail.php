<?php

namespace ZesharCRM\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LeadSubjectEmail
 */
class LeadSubjectEmail
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $theme;

    /**
     * @var string
     */
    private $message;

    /**
     * @var \DateTime
     */
    private $createdAt;

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
     * Set theme
     *
     * @param string $theme
     * @return LeadSubjectEmail
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string 
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return LeadSubjectEmail
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return LeadSubjectEmail
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set lead
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject $lead
     * @return LeadSubjectEmail
     */
    public function setLeadId(\ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject $lead)
    {
        $this->lead = $lead;

        return $this;
    }

    /**
     * Get lead
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject
     */
    public function getLead()
    {
        return $this->lead;
    }
}
