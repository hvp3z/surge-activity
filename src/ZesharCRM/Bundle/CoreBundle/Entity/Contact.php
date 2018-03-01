<?php

namespace ZesharCRM\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ZesharCRM\Bundle\CoreBundle\Enum\ContactType;

/**
 * Contact
 */
class Contact
{
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
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\ContactCard
     */
    private $contactCard;


    /**
     * Set contactCard
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\ContactCard $contactCard
     * @return Contact
     */
    public function setContactCard(\ZesharCRM\Bundle\CoreBundle\Entity\ContactCard $contactCard = null)
    {
        $this->contactCard = $contactCard;

        return $this;
    }

    /**
     * Get contactCard
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\ContactCard 
     */
    public function getContactCard()
    {
        return $this->contactCard;
    }
    /**
     * @var integer
     */
    private $type;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;


    /**
     * Set type
     *
     * @param integer $type
     * @return Contact
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
     * Set name
     *
     * @param string $name
     * @return Contact
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
     * Set value
     *
     * @param string $value
     * @return Contact
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }
    
    private $donotCall; // this is a confuse - donotCall means really "Contact Status" - yes/no/neglected - real boolean "donotCall" is named "dnc" below
    private $dnc; // real dnc (do not call)
    private $donotEmail;
    
    public function getDonotCall() 
    {
        return isset($this->donotCall) ? $this->donotCall : FALSE;
    }

    public function setDonotCall($donotCall)
    {
        $this->donotCall = $donotCall;
        return $this;
    }

    public function getDonotEmail()
    {
        return isset($this->donotEmail) ? $this->donotEmail : FALSE;
    }

    public function setDonotEmail($donotEmail)
    {
        $this->donotEmail = $donotEmail;
        return $this;
    }
    
    public function getDnc()
    {
        return $this->dnc;
    }

    public function setDnc($dnc)
    {
        $this->dnc = $dnc;
        return $this;
    }

    private $isDefault;

    public function getIsDefault()
    {
        return $this->isDefault;
    }

    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;
        return $this;
    }


    public function getContactCardTypeString() {
        $mapping = ContactType::getHumanTitlesMap();
        return isset($mapping[$this->getType()]) ? $mapping[$this->getType()] : '';
    }

    public function __toString() {

        return $this->getValue();
    }

    public function __clone() {
        if ($this->id) {
            $this->id = null;
        }
    }
}
