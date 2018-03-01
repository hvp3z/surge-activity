<?php

namespace ZesharCRM\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ZesharCRM\Bundle\CoreBundle\Enum\OperationType;

/**
 * Operation
 */
class Operation implements DateRangeInterface
{
    const DATE_FIELD = 'performed_at';

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
     * @var \DateTime
     */
    private $performedAt;

    /**
     * @var integer
     */
    private $operationType;

    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\User
     */
    private $performer;


    /**
     * Set performedAt
     *
     * @param \DateTime $performedAt
     * @return Operation
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
     * @return Operation
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
     * Set performer
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\User $performer
     * @return Operation
     */
    public function setPerformer(\ZesharCRM\Bundle\CoreBundle\Entity\User $performer)
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
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject
     */
    private $entity;


    /**
     * Set entity
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject $entity
     * @return Operation
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject
     */
    public function getEntity()
    {
        return $this->entity;
    }

    public function getTypeString() {
        $mapping = OperationType::getHumanTitlesMap();
        return isset($mapping[$this->getOperationType()]) ? $mapping[$this->getOperationType()] : '';
    }

    public function getDateField()
    {
        return self::DATE_FIELD;
    }


}
