<?php

namespace ZesharCRM\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LeadPrequalificationDriver
 */
class LeadPrequalificationDriver
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $dob;

    /**
     * @var string
     */
    private $license;

    /**
     * @var integer
     */
    private $ageLicensed;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $tickets;

    private $lead;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tickets = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add addTicket
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\DriverTicket $ticket
     * @return LeadPrequalificationDriver
     */
    public function addTicket(\ZesharCRM\Bundle\CoreBundle\Entity\DriverTicket $ticket)
    {
        $this->tickets[] = $ticket;

        return $this;
    }

    /**
     * Remove ticket
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\DriverTicket $ticket
     */
    public function removeTicket(\ZesharCRM\Bundle\CoreBundle\Entity\DriverTicket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * Set lead
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Lead $lead
     * @return LeadPrequalificationDriver
     */
    public function setLead($lead)
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
     * Set name
     *
     * @param string $name
     * @return LeadPrequalificationDriver
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set dob
     *
     * @param \DateTime $dob
     * @return LeadPrequalificationDriver
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Get dob
     *
     * @return \DateTime
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Set license
     *
     * @param string $license
     * @return LeadPrequalificationDriver
     */
    public function setLicense($license)
    {
        $this->license = $license;

        return $this;
    }

    /**
     * Get license
     *
     * @return string 
     */
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * Set ageLicensed
     *
     * @param integer $ageLicensed
     * @return LeadPrequalificationDriver
     */
    public function setAgeLicensed($ageLicensed)
    {
        $this->ageLicensed = $ageLicensed;

        return $this;
    }

    /**
     * Get ageLicensed
     *
     * @return integer 
     */
    public function getAgeLicensed()
    {
        return $this->ageLicensed;
    }

    public function setTickets($tickets)
    {
        $this->tickets = $tickets;

        return $this;
    }
}
