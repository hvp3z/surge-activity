<?php

namespace ZesharCRM\Bundle\CoreBundle\Entity;

use ZesharCRM\Bundle\CoreBundle\Enum\ProductType;

/**
 * Product
 */
class Product
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
     * @var float
     */
    private $monthlyRate;

    /**
     * @var float
     */
    private $yearlyRate;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $billingInfo;

    /**
     * @var integer
     */
    private $productType;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->billingInfo = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getMonthlyRate()
    {
        return $this->monthlyRate;
    }

    /**
     * @param int $monthlyRate
     */
    public function setMonthlyRate($monthlyRate)
    {
        $this->monthlyRate = $monthlyRate;
    }

    /**
     * @return int
     */
    public function getYearlyRate()
    {
        return $this->yearlyRate;
    }

    /**
     * @param int $yearlyRate
     */
    public function setYearlyRate($yearlyRate)
    {
        $this->yearlyRate = $yearlyRate;
    }

    /**
     * Remove billingInfo
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\BillingInfo $billingInfo
     */
    public function removeBillingInfo(\ZesharCRM\Bundle\CoreBundle\Entity\BillingInfo $billingInfo)
    {
        $this->billingInfo->removeElement($billingInfo);
    }

    /**
     * Get billingInfo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBillingInfo()
    {
        return $this->billingInfo;
    }

    /**
     * @return int
     */
    public function getProductType()
    {
        return $this->productType;
    }

    /**
     * @param int $productType
     */
    public function setProductType($productType)
    {
        $this->productType = $productType;
    }

    /**
     * @return string
     */
    public function getProductTypeString()
    {
        $productType =  $this->productType;
        $productTypesArr = ProductType::getHumanTitlesMap();
        return $productTypesArr[$productType];
    }


}

