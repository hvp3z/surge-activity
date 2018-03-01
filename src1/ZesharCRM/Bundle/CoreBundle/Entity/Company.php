<?php

namespace ZesharCRM\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Company
 */
class Company
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
     * @var string
     */
    private $firstAddress;

    /**
     * @var string
     */
    private $secondAddress;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $postalCode;

    /**
     * @var string
     */
    private $phoneNumber;

    /**
     * @var string
     */
    private $phoneExt;

    /**
     * @var integer
     */
    private $industry;


    private $billingStatus;



    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $users;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $scoringCriterias;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->scoringCriterias = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Company
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
     * Set firstAddress
     *
     * @param string $firstAddress
     * @return Company
     */
    public function setFirstAddress($firstAddress)
    {
        $this->firstAddress = $firstAddress;

        return $this;
    }

    /**
     * Get firstAddress
     *
     * @return string 
     */
    public function getFirstAddress()
    {
        return $this->firstAddress;
    }

    /**
     * Set secondAddress
     *
     * @param string $secondAddress
     * @return Company
     */
    public function setSecondAddress($secondAddress)
    {
        $this->secondAddress = $secondAddress;

        return $this;
    }

    /**
     * Get secondAddress
     *
     * @return string 
     */
    public function getSecondAddress()
    {
        return $this->secondAddress;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Company
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Company
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     * @return Company
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string 
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     * @return Company
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string 
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getPhoneExt()
    {
        return $this->phoneExt;
    }

    /**
     * @param string $phoneExt
     */
    public function setPhoneExt($phoneExt)
    {
        $this->phoneExt = $phoneExt;
    }

    /**
     * @return int
     */
    public function getIndustry()
    {
        return $this->industry;
    }

    /**
     * @param int $industry
     */
    public function setIndustry($industry)
    {
        $this->industry = $industry;
    }

    /**
     * Add scoringCriteria
     *
     * @param \ZesharCRM\Bundle\LeadScoringBundle\Entity\scoringCriteria $scoringCriteria
     * @return Company
     */
    public function addScoringCriteria(\ZesharCRM\Bundle\LeadScoringBundle\Entity\scoringCriteria $scoringCriteria)
    {
        $this->scoringCriterias[] = $scoringCriteria;

        return $this;
    }

    /**
     * Remove scoringCriteria
     *
     * @param \ZesharCRM\Bundle\LeadScoringBundle\Entity\scoringCriteria $scoringCriteria
     */
    public function removeScoringCriteria(\ZesharCRM\Bundle\LeadScoringBundle\Entity\scoringCriteria $scoringCriteria)
    {
        $this->scoringCriterias->removeElement($scoringCriteria);
    }

    /**
     * Get scoringCriterias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getScoringCriterias()
    {
        return $this->scoringCriterias;
    }


    /**
     * Add users
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\User $users
     * @return Company
     */
    public function addUser(\ZesharCRM\Bundle\CoreBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\User $users
     */
    public function removeUser(\ZesharCRM\Bundle\CoreBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getBillingStatus()
    {
        $status = 'Inactive';

        $users = $this->users;
        if(!empty($users)){
            $user = $users[0];
            $billingInfo = $user->getBillingInfo();

            if(!empty($billingInfo)){
                $billingInfo = $billingInfo[0];
                if($billingInfo){
                    $status = $billingInfo->getSubscriptionStatusString();
                }
            }
        }

        return $status;
    }
}
