<?php

namespace ZesharCRM\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;
use ZesharCRM\Bundle\CoreBundle\Entity\Opportunity;

/**
 * LeadAttachment
 */
class LeadAttachment
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
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\Attachment
     */
    private $attachment;

    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject
     */
        private $leadSubject;


    /**
     * Set attachment
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Attachment $attachment
     * @return LeadAttachment
     */
    public function setAttachment(\ZesharCRM\Bundle\CoreBundle\Entity\Attachment $attachment = null)
    {
        $this->attachment = $attachment;

        return $this;
    }

    /**
     * Get attachment
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\Attachment 
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * Set lead
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject $leadSubject
     * @return LeadAttachment
     */
    public function setLeadSubject(\ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject $leadSubject)
    {
        $this->leadSubject = $leadSubject;

        return $this;
    }

    /**
     * Get lead
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject
     */
    public function getLead()
    {
        return $this->leadSubject;
    }


    /**
     * Set lead
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\Lead $lead
     * @return LeadAttachment
     */
    public function setLead(\ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject $lead)
    {
        $this->leadSubject = $lead;

        return $this;
    }

    /**
     * Get lead
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject
     */
    public function getLeadSubject()
    {
        return $this->leadSubject;
    }

    public function addOpportunityAttachment()
    {
        /** @var $em EntityManager */
        $em = $this->getEntityManager();

        $opportunity = $this->getSimilarOpportunity($em);

        /** @var $opportunity Opportunity */
        if ($opportunity) {
            $opportunityAttachment = new OpportunityAttachment();
            $this->setSimilarOpportunityAttachment($em, $opportunityAttachment, $opportunity);
        }

        return;
    }

    public function updateOpportunityAttachment()
    {
        /** @var $em EntityManager */
        $em = $this->getEntityManager();

        $opportunity = $this->getSimilarOpportunity($em);

        /** @var $opportunity Opportunity */
        if ($opportunity) {
            $opportunityAttachment = $this->getSimilarOpportunityAttachment($em, $opportunity);
            /** @var $opportunityAttachment OpportunityAttachment */
            if ($opportunityAttachment) {
                $this->setSimilarOpportunityAttachment($em, $opportunityAttachment, $opportunity);
            }

        }

        return;
    }

    public function removeOpportunityAttachment()
    {
        /** @var $em EntityManager */
        $em = $this->getEntityManager();

        $opportunity = $this->getSimilarOpportunity($em);

        /** @var $opportunity Opportunity */
        if ($opportunity) {
            $opportunityAttachment = $this->getSimilarOpportunityAttachment($em, $opportunity);
            if ($opportunityAttachment) {
                $em->remove($opportunityAttachment);
                $em->flush();
            }
        }

        return;
    }

    private function getEntityManager()
    {
        global $kernel;
        if ( 'AppCache' == get_class($kernel) )
        {
            $kernel = $kernel->getKernel();
        }

        /** @var $em EntityManager */
        $em = $kernel->getContainer()->get( 'doctrine.orm.entity_manager' );

        return $em;
    }

    private function getSimilarOpportunity(EntityManager $em)
    {
        $opportunity = $em->getRepository('ZesharCRMCoreBundle:Opportunity')->findOneBy(array('lead' => $this->getLead()));

        return $opportunity;
    }

    private function getSimilarOpportunityAttachment(EntityManager $em, Opportunity $opportunity)
    {
        $opportunityAttachment = $em->getRepository('ZesharCRMCoreBundle:OpportunityAttachment')->findOneBy(array('opportunity' => $opportunity, 'attachment' => $this->getAttachment()));

        return $opportunityAttachment;
    }

    private function setSimilarOpportunityAttachment(EntityManager $em, OpportunityAttachment $opportunityAttachment, Opportunity $opportunity)
    {
        $opportunityAttachment
            ->setAttachment($this->getAttachment())
            ->setOpportunity($opportunity)
        ;
        $opportunity->addAttachment($opportunityAttachment);

        $em->persist($opportunity);
        $em->persist($opportunityAttachment);

        $em->flush();
    }
}
