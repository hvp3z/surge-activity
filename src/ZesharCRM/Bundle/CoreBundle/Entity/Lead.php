<?php

namespace ZesharCRM\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ZesharCRM\Bundle\CoreBundle\Enum\LeadType;
use ZesharCRM\Bundle\CoreBundle\Enum\DealStatus;

/**
 * Lead
 */
class Lead extends LeadSubject
{
    /**
     * @var integer
     */
    private $type;

    /**
     * Set type
     *
     * @param integer $type
     * @return Lead
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
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\User
     */
    private $creator;


    /**
     * Set creator
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\User $creator
     * @return Lead
     */
    public function setCreator(\ZesharCRM\Bundle\CoreBundle\Entity\User $creator = null)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\User
     */
    public function getCreator()
    {
        return $this->creator;
    }
    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\User
     */
    private $assignee;


    /**
     * Set assignee
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\User $assignee
     * @return Lead
     */
    public function setAssignee(\ZesharCRM\Bundle\CoreBundle\Entity\User $assignee = null)
    {
        $this->assignee = $assignee;

        return $this;
    }

    /**
     * Get assignee
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\User
     */
    public function getAssignee()
    {
        return $this->assignee;
    }


}
