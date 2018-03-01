<?php

namespace ZesharCRM\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BillingInfo
 */
class BillingInfo
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $frequency;

    /**
     * @var \DateTime
     */
    private $effectiveDate;

    /**
     * @var \DateTime
     */
    private $expirationDate;

    /**
     * @var integer
     */
    private $subscriptionStatus;

    /**
     * @var integer
     */
    private $license;

    /**
     * @var float
     */
    private $credit;

    /**
     * @var integer
     */
    private $creator;

    /**
     * @var integer
     */
    private $subscriptionProduct;

    /**
     * @var string
     */
    private $subscriptionId;


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
     * Set frequency
     *
     * @param integer $frequency
     * @return BillingInfo
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * Get frequency
     *
     * @return integer 
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Set effectiveDate
     *
     * @param \DateTime $effectiveDate
     * @return BillingInfo
     */
    public function setEffectiveDate($effectiveDate)
    {
        $this->effectiveDate = $effectiveDate;

        return $this;
    }

    /**
     * Get effectiveDate
     *
     * @return \DateTime 
     */
    public function getEffectiveDate()
    {
        return $this->effectiveDate;
    }

    /**
     * Set expirationDate
     *
     * @param \DateTime $expirationDate
     * @return BillingInfo
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * Get expirationDate
     *
     * @return \DateTime 
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * Set subscriptionProduct
     *
     * @param integer $subscriptionProduct
     * @return BillingInfo
     */
    public function setSubscriptionProduct($subscriptionProduct)
    {
        $this->subscriptionProduct = $subscriptionProduct;

        return $this;
    }

    /**
     * Get subscriptionProduct
     *
     * @return integer 
     */
    public function getSubscriptionProduct()
    {
        return $this->subscriptionProduct;
    }

    /**
     * Set subscriptionStatus
     *
     * @param integer $subscriptionStatus
     * @return BillingInfo
     */
    public function setSubscriptionStatus($subscriptionStatus)
    {
        $this->subscriptionStatus = $subscriptionStatus;

        return $this;
    }

    /**
     * Get subscriptionStatus
     *
     * @return integer 
     */
    public function getSubscriptionStatus()
    {
        return $this->subscriptionStatus;
    }

    /**
     * Set license
     *
     * @param integer $license
     * @return BillingInfo
     */
    public function setLicense($license)
    {
        $this->license = $license;

        return $this;
    }

    /**
     * Get license
     *
     * @return integer 
     */
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * Set credit
     *
     * @param integer $credit
     * @return BillingInfo
     */
    public function setCredit($credit)
    {
        $this->credit = $credit;

        return $this;
    }

    /**
     * Get credit
     *
     * @return integer 
     */
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * @return int
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param int $creator
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    }

    /**
     * @return int
     */
    public function getSubscriptionId()
    {
        return $this->subscriptionId;
    }

    /**
     * @param int $subscriptionId
     */
    public function setSubscriptionId($subscriptionId)
    {
        $this->subscriptionId = $subscriptionId;
    }




    public function __toString()
    {
        return 'Account Info';
    }

    public function getSubscriptionStatusString()
    {
        $status = $this->subscriptionStatus;

        switch($status){
            case '0':
                return 'Inactive';
            case '1':
                return 'Active';
            default:
                return 'Unknown';
        }
    }

}
