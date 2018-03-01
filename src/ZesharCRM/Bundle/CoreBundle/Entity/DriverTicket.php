<?php

namespace ZesharCRM\Bundle\CoreBundle\Entity;

use ZesharCRM\Bundle\CoreBundle\Enum\DriverTicketType;
use Doctrine\ORM\Mapping as ORM;

/**
 * DriverTicket
 */
class DriverTicket
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\LeadPrequalificationDriver
     */
    private $driver;


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
     * Set type
     *
     * @param integer $type
     * @return DriverTicket
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set driver
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadPrequalificationDriver $driver
     * @return DriverTicket
     */
    public function setDriver(\ZesharCRM\Bundle\CoreBundle\Entity\LeadPrequalificationDriver $driver = null)
    {
        $this->driver = $driver;

        return $this;
    }

    public function getTypeString() {
        $mapping = DriverTicketType::getHumanTitles();
        return isset($mapping[$this->getType()]) ? $mapping[$this->getType()] : '';
    }

    /**
     * Get driver
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\LeadPrequalificationDriver
     */
    public function getDriver()
    {
        return $this->driver;
    }
}
