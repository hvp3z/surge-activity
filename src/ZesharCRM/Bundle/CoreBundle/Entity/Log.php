<?php

namespace ZesharCRM\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ZesharCRM\Bundle\CoreBundle\Enum\LogType;

/**
 * Operation
 */
class Log
{
    /**
     * @var integer
     */
    private $id;

    private $performer;

    private $performedAt;

    private $operationType;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $operationType
     * @return Log
     */
    public function setOperationType($operationType)
    {
        $this->operationType = $operationType;

        return $this;
    }

    /**
     * @return integer
     */
    public function getOperationType()
    {
        return $this->operationType;
    }

    /**
     * @param \DateTime $performedAt
     */
    public function setPerformedAt($performedAt)
    {
        $this->performedAt = $performedAt;
    }

    /**
     * @param \DateTime
     */
    public function getPerformedAt()
    {
        return $this->performedAt;
    }

    /**
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\User $performer
     * @return Log
     */
    public function setPerformer($performer)
    {
        $this->performer = $performer;
        return $this;
    }

    /**
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\User
     */
    public function getPerformer()
    {
        return $this->performer;
    }

    public function getTypeString() {
        $mapping = LogType::getHumanTitlesMap();
        return isset($mapping[$this->getOperationType()]) ? $mapping[$this->getOperationType()] : '';
    }

}
