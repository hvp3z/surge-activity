<?php

namespace ZesharCRM\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * Contact
 */
class User extends BaseUser
{
    
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $assignedLeads;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $createdLeads;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $assignedActivities;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $createdActivities;

    /**
     * @var string
     */
    private $widgetsData;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $performedOperations;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $performedMilestoneOperations;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $performedActions;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $assignedCallReports;

    /**
     * @var integer
     */
    private $company;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $leadCategories;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $leadEventTypes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $leadSources;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $leadTypes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $payments;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $creditCards;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $billingInfo;

    /**
     * @var integer
     */
    private $disabled;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->assignedLeads = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdLeads = new \Doctrine\Common\Collections\ArrayCollection();
        $this->performedActions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->performedMilestoneOperations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->leadCategories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->leadEventTypes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->leadSources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->leadTypes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->payments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->creditCards = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add assignedLeads
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Lead $assignedLeads
     * @return User
     */
    public function addAssignedLead(\ZesharCRM\Bundle\CoreBundle\Entity\Lead $assignedLeads)
    {
        $this->assignedLeads[] = $assignedLeads;

        return $this;
    }

    /**
     * Remove assignedLeads
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Lead $assignedLeads
     */
    public function removeAssignedLead(\ZesharCRM\Bundle\CoreBundle\Entity\Lead $assignedLeads)
    {
        $this->assignedLeads->removeElement($assignedLeads);
    }

    /**
     * Get assignedLeads
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAssignedLeads()
    {
        return $this->assignedLeads;
    }

    /**
     * Add createdLeads
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Lead $createdLeads
     * @return User
     */
    public function addCreatedLead(\ZesharCRM\Bundle\CoreBundle\Entity\Lead $createdLeads)
    {
        $this->createdLeads[] = $createdLeads;

        return $this;
    }

    /**
     * Remove createdLeads
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Lead $createdLeads
     */
    public function removeCreatedLead(\ZesharCRM\Bundle\CoreBundle\Entity\Lead $createdLeads)
    {
        $this->createdLeads->removeElement($createdLeads);
    }

    /**
     * Get createdLeads
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCreatedLeads()
    {
        return $this->createdLeads;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $assignedOpportunities;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $createdOpportunities;

    /**
     * @var string
     */
    private $lspCode;

    /**
     * Get lspCode
     *
     * @return string
     */
    public function getLspCode()
    {
        return $this->lspCode;
    }

    /**
     * Set lspCode
     *
     * @param string $lspCode
     * @return User
     */
    public function setLspCode($lspCode)
    {
        $this->lspCode = $lspCode;

        return $this;
    }


    /**
     * Add assignedOpportunities
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Opportunity $assignedOpportunities
     * @return User
     */
    public function addAssignedOpportunity(\ZesharCRM\Bundle\CoreBundle\Entity\Opportunity $assignedOpportunities)
    {
        $this->assignedOpportunities[] = $assignedOpportunities;

        return $this;
    }

    /**
     * Remove assignedOpportunities
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Opportunity $assignedOpportunities
     */
    public function removeAssignedOpportunity(\ZesharCRM\Bundle\CoreBundle\Entity\Opportunity $assignedOpportunities)
    {
        $this->assignedOpportunities->removeElement($assignedOpportunities);
    }

    /**
     * Get assignedOpportunities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAssignedOpportunities()
    {
        return $this->assignedOpportunities;
    }

    /**
     * Add createdOpportunities
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Opportunity $createdOpportunities
     * @return User
     */
    public function addCreatedOpportunity(\ZesharCRM\Bundle\CoreBundle\Entity\Opportunity $createdOpportunities)
    {
        $this->createdOpportunities[] = $createdOpportunities;

        return $this;
    }

    /**
     * Remove createdOpportunities
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Opportunity $createdOpportunities
     */
    public function removeCreatedOpportunity(\ZesharCRM\Bundle\CoreBundle\Entity\Opportunity $createdOpportunities)
    {
        $this->createdOpportunities->removeElement($createdOpportunities);
    }

    /**
     * Get createdOpportunities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCreatedOpportunities()
    {
        return $this->createdOpportunities;
    }
    
    

    /**
     * Set widgetsData
     *
     * @param string $widgetsData
     * @return User
     */
    public function setWidgetsData($widgetsData)
    {
        $this->widgetsData = $widgetsData;

        return $this;
    }

    /**
     * Get widgetsData
     *
     * @return string 
     */
    public function getWidgetsData()
    {
        return $this->widgetsData;
    }

    /**
     * Add assignedActivities
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Activity $assignedActivities
     * @return User
     */
    public function addAssignedActivity(\ZesharCRM\Bundle\CoreBundle\Entity\Activity $assignedActivities)
    {
        $this->assignedActivities[] = $assignedActivities;

        return $this;
    }

    /**
     * Remove assignedActivities
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Activity $assignedActivities
     */
    public function removeAssignedActivity(\ZesharCRM\Bundle\CoreBundle\Entity\Activity $assignedActivities)
    {
        $this->assignedActivities->removeElement($assignedActivities);
    }

    /**
     * Get assignedActivities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAssignedActivities()
    {
        return $this->assignedActivities;
    }

    /**
     * Add createdActivities
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Activity $createdActivities
     * @return User
     */
    public function addCreatedActivity(\ZesharCRM\Bundle\CoreBundle\Entity\Activity $createdActivities)
    {
        $this->createdActivities[] = $createdActivities;

        return $this;
    }

    /**
     * Remove createdActivities
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Activity $createdActivities
     */
    public function removeCreatedActivity(\ZesharCRM\Bundle\CoreBundle\Entity\Activity $createdActivities)
    {
        $this->createdActivities->removeElement($createdActivities);
    }

    /**
     * Get createdActivities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCreatedActivities()
    {
        return $this->createdActivities;
    }

    /**
     * Add performedOperations
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Operation $performedOperations
     * @return User
     */
    public function addPerformedOperation(\ZesharCRM\Bundle\CoreBundle\Entity\Operation $performedOperations)
    {
        $this->performedOperations[] = $performedOperations;

        return $this;
    }

    /**
     * Add performedMilestoneOperation
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\MilestoneOperation $performedMilestoneOperation
     * @return User
     */
    public function addPerformedMilestoneOperation(\ZesharCRM\Bundle\CoreBundle\Entity\MilestoneOperation $performedMilestoneOperation)
    {
        $this->performedMilestoneOperations[] = $performedMilestoneOperation;

        return $this;
    }

    /**
     * Remove performedOperations
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Operation $performedOperations
     */
    public function removePerformedOperation(\ZesharCRM\Bundle\CoreBundle\Entity\Operation $performedOperations)
    {
        $this->performedOperations->removeElement($performedOperations);
    }

    /**
     * Remove performedMilestoneOperation
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\MilestoneOperation $performedMilestoneOperation
     */
    public function removePerformedMilestoneOperation(\ZesharCRM\Bundle\CoreBundle\Entity\MilestoneOperation $performedMilestoneOperation)
    {
        $this->performedMilestoneOperations->removeElement($performedMilestoneOperation);
    }

    /**
     * Get performedOperations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPerformedOperations()
    {
        return $this->performedOperations;
    }

    /**
     * Get performedMilestoneOperation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPerformedMilestoneOperation()
    {
        return $this->performedMilestoneOperations;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $performedActions
     */
    public function setPerformedActions($performedActions)
    {
        $this->performedActions = $performedActions;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPerformedActions()
    {
        return $this->performedActions;
    }

    /**
     * Add assignedCallReports
     *
     * @param \ZesharCRM\Bundle\CallsBundle\Entity\CallReporting $assignedCallReports
     * @return User
     */
    public function addAssignedCallReport(\ZesharCRM\Bundle\CallsBundle\Entity\CallReporting $assignedCallReports)
    {
        $this->assignedCallReports[] = $assignedCallReports;

        return $this;
    }

    /**
     * Remove assignedCallReports
     *
     * @param \ZesharCRM\Bundle\CallsBundle\Entity\CallReporting $assignedCallReports
     */
    public function removeAssignedCallReport(\ZesharCRM\Bundle\CallsBundle\Entity\CallReporting $assignedCallReports)
    {
        $this->assignedCallReports->removeElement($assignedCallReports);
    }

    /**
     * Get assignedCallReports
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAssignedCallReports()
    {
        return $this->assignedCallReports;
    }

    /**
     * @param int $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return int
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Add leadCategories
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadCategory $leadCategories
     * @return User
     */
    public function addLeadCategory(\ZesharCRM\Bundle\CoreBundle\Entity\LeadCategory $leadCategories)
    {
        $this->leadCategories[] = $leadCategories;

        return $this;
    }

    /**
     * Remove leadCategories
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadCategory $leadCategories
     */
    public function removeLeadCategory(\ZesharCRM\Bundle\CoreBundle\Entity\LeadCategory $leadCategories)
    {
        $this->leadCategories->removeElement($leadCategories);
    }

    /**
     * Get leadCategories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLeadCategories()
    {
        return $this->leadCategories;
    }



    /**
     * Add leadEventTypes
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadEventType $leadEventTypes
     * @return User
     */
    public function addLeadEventType(\ZesharCRM\Bundle\CoreBundle\Entity\LeadEventType $leadEventTypes)
    {
        $this->leadEventTypes[] = $leadEventTypes;

        return $this;
    }

    /**
     * Remove leadEventTypes
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadEventType $leadEventTypes
     */
    public function removeLeadEventType(\ZesharCRM\Bundle\CoreBundle\Entity\LeadEventType $leadEventTypes)
    {
        $this->leadEventTypes->removeElement($leadEventTypes);
    }

    /**
     * Get leadEventTypes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLeadEventTypes()
    {
        return $this->leadEventTypes;
    }



    /**
     * Add leadSources
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadSource $leadSources
     * @return User
     */
    public function addLeadSource(\ZesharCRM\Bundle\CoreBundle\Entity\LeadSource $leadSources)
    {
        $this->leadSources[] = $leadSources;

        return $this;
    }

    /**
     * Remove leadSources
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadSource $leadSources
     */
    public function removeLeadSource(\ZesharCRM\Bundle\CoreBundle\Entity\LeadSource $leadSources)
    {
        $this->leadSources->removeElement($leadSources);
    }

    /**
     * Get leadSources
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLeadSources()
    {
        return $this->leadSources;
    }


    /**
     * Add leadTypes
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadType $leadTypes
     * @return User
     */
    public function addLeadType(\ZesharCRM\Bundle\CoreBundle\Entity\LeadType $leadTypes)
    {
        $this->leadTypes[] = $leadTypes;

        return $this;
    }

    /**
     * Remove leadTypes
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadType $leadTypes
     */
    public function removeLeadType(\ZesharCRM\Bundle\CoreBundle\Entity\LeadType $leadTypes)
    {
        $this->leadTypes->removeElement($leadTypes);
    }

    /**
     * Get leadTypes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLeadTypes()
    {
        return $this->leadTypes;
    }



    /**
     * Add payments
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\PaymentHistory $payments
     * @return User
     */
    public function addPayment(\ZesharCRM\Bundle\CoreBundle\Entity\PaymentHistory $payments)
    {
        $this->payments[] = $payments;

        return $this;
    }

    /**
     * Remove payments
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\PaymentHistory $payments
     */
    public function removePayment(\ZesharCRM\Bundle\CoreBundle\Entity\PaymentHistory $payments)
    {
        $this->payments->removeElement($payments);
    }

    /**
     * Get payments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
 * Add creditCards
 *
 * @param \ZesharCRM\Bundle\CoreBundle\Entity\CreditCard $creditCards
 * @return User
 */
    public function addCreditCard(\ZesharCRM\Bundle\CoreBundle\Entity\CreditCard $creditCards)
    {
        $this->creditCards[] = $creditCards;

        return $this;
    }

    /**
     * Remove creditCards
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\PaymentHistory $creditCards
     */
    public function removeCreditCard(\ZesharCRM\Bundle\CoreBundle\Entity\PaymentHistory $creditCards)
    {
        $this->creditCards->removeElement($creditCards);
    }

    /**
     * Get creditCards
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCreditCards()
    {
        return $this->creditCards;
    }



    /**
     * Add billingInfo
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\BillingInfo $billingInfo
     * @return User
     */
    public function addBillingInfo(\ZesharCRM\Bundle\CoreBundle\Entity\BillingInfo $billingInfo)
    {
        $this->billingInfo[] = $billingInfo;

        return $this;
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
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return int
     */
    public function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * @param int $disabled
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;
    }

}
