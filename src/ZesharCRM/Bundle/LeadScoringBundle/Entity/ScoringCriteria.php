<?php

namespace ZesharCRM\Bundle\LeadScoringBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LeadScoring
 */
class ScoringCriteria
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
     * @var integer
     */
    private $parent;

    /**
     * @var integer
     */
    private $score;

    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\Company
     */
    private $company;

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
     * @return ScoringCriteria
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
     * Set parent
     *
     * @param integer $parent
     * @return ScoringCriteria
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return integer 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set score
     *
     * @param integer $score
     * @return ScoringCriteria
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer 
     */
    public function getScore()
    {
        return $this->score;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $children;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add children
     *
     * @param \ZesharCRM\Bundle\LeadScoringBundle\Entity\ScoringCriteria $children
     * @return ScoringCriteria
     */
    public function addChild(\ZesharCRM\Bundle\LeadScoringBundle\Entity\ScoringCriteria $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \ZesharCRM\Bundle\LeadScoringBundle\Entity\ScoringCriteria $children
     */
    public function removeChild(\ZesharCRM\Bundle\LeadScoringBundle\Entity\ScoringCriteria $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Company $company
     * @return ScoringCriteria
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
