<?php

namespace ZesharCRM\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MilestoneOperation
 */
class MilestoneOperation implements DateRangeInterface
{
    const DATE_FIELD = 'performed_at';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\User
     */
    private $performer;

    /**
     * @var \DateTime
     */
    private $performedAt;

    /**
     * @var integer
     */
    private $operationType;

    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject
     */
    private $leadSubject;


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
     * Set performer
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\User $performer
     * @return MilestoneOperation
     */
    public function setPerformer($performer)
    {
        $this->performer = $performer;

        return $this;
    }

    /**
     * Get performer
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\User
     */
    public function getPerformer()
    {
        return $this->performer;
    }

    /**
     * Set performedAt
     *
     * @param \DateTime $performedAt
     * @return MilestoneOperation
     */
    public function setPerformedAt($performedAt)
    {
        $this->performedAt = $performedAt;

        return $this;
    }

    /**
     * Get performedAt
     *
     * @return \DateTime 
     */
    public function getPerformedAt()
    {
        return $this->performedAt;
    }

    /**
     * Set operationType
     *
     * @param integer $operationType
     * @return MilestoneOperation
     */
    public function setOperationType($operationType)
    {
        $this->operationType = $operationType;

        return $this;
    }

    /**
     * Get operationType
     *
     * @return integer 
     */
    public function getOperationType()
    {
        return $this->operationType;
    }

    /**
     * Set leadSubject
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject $leadSubject
     * @return MilestoneOperation
     */
    public function setLeadSubject($leadSubject)
    {
        $this->leadSubject = $leadSubject;

        return $this;
    }

    /**
     * Get leadSubject
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject
     */
    public function getLeadSubject()
    {
        return $this->leadSubject;
    }

    public function getDateField()
    {
        return self::DATE_FIELD;
    }
}
