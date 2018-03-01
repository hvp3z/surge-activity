<?php

namespace ZesharCRM\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LeadPrequalificationAuto
 */
class LeadPrequalificationAuto
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $year;

    /**
     * @var string
     */
    private $make;

    /**
     * @var string
     */
    private $model;

    /**
     * @var string
     */
    private $vinNumber;

    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\Lead
     */
    private $lead;

    /**
     * Set lead
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Lead $lead
     * @return LeadPrequalificationAuto
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
     * Set year
     *
     * @param integer $year
     * @return LeadPrequalificationAuto
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set make
     *
     * @param string $make
     * @return LeadPrequalificationAuto
     */
    public function setMake($make)
    {
        $this->make = $make;

        return $this;
    }

    /**
     * Get make
     *
     * @return string 
     */
    public function getMake()
    {
        return $this->make;
    }

    /**
     * Set model
     *
     * @param string $model
     * @return LeadPrequalificationAuto
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string 
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set vinNumber
     *
     * @param string $vinNumber
     * @return LeadPrequalificationAuto
     */
    public function setVinNumber($vinNumber)
    {
        $this->vinNumber = $vinNumber;

        return $this;
    }

    /**
     * Get vinNumber
     *
     * @return string 
     */
    public function getVinNumber()
    {
        return $this->vinNumber;
    }
}
