<?php

namespace ZesharCRM\Bundle\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use ZesharCRM\Bundle\CoreBundle\Enum\MilestoneOperationType;
use ZesharCRM\Bundle\CoreBundle\Enum\LeadType;
use ZesharCRM\Bundle\CoreBundle\Enum\OpportunityPriority;
use ZesharCRM\Bundle\CoreBundle\Enum\OperationType;

class MilestoneOperationRepository extends EntityRepository
{
    public function getChildEntityByUserAndDate($user, $month, $year, $propertyTitle)
    {   ;

        $qb = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('MAX(mo.performedAt) as performedAt, leadS.id as leadId')
            ->from('ZesharCRMCoreBundle:MilestoneOperation', 'mo')
            ->join('mo.leadSubject', 'leadS')
            ->where('mo.performer = :user')
            ->groupBy('mo.leadSubject')
            ->setParameter('user', $user);
        $result = $qb->getQuery()->getResult();


        $operations = array();
        $leads = array();
        $quotes = array();
        $lostQuotes = array();

        foreach ($result as $lead) {
            $date = date_create_from_format('Y-m-d H:i:s', $lead['performedAt']);
            $date->getTimestamp();


            $leadEntity = $this->getEntityManager()->getRepository('ZesharCRMCoreBundle:leadSubject')->find($lead['leadId']);

            $operation = $this->findOneBy(array('performedAt' => $date, 'leadSubject' => $leadEntity));
            $operationType = $operation->getOperationType();

            if ($operationType == MilestoneOperationType::NEW_LEAD) {
                $leads[] = $lead['leadId'];
            }
            if ($operationType == MilestoneOperationType::OPPORTUNITY_TO_QUOTE) {
                $quotes[] = $lead['leadId'];
            }
            if ($operationType == MilestoneOperationType::QUOTE_TO_OPPORTUNITY) {
                $lostQuotes[] = $lead['leadId'];
            }

            $operations[] = $operation->getId();
        }

        $qb = $this->getEntityManager()
        ->createQueryBuilder();
        $qb->select('childEntity.title, childEntity.id, SUM(if(leadSubject INSTANCE OF ZesharCRMCoreBundle:Opportunity, if(FIELD(\'opportunity\' \'id\') IN (:lostQuotes), FIELD(\'opportunity\' \'quotedAmount\'), 0), 0)) AS lostQuotedAmount, SUM(if(leadSubject INSTANCE OF ZesharCRMCoreBundle:Opportunity, if(FIELD(\'opportunity\' \'id\') IN (:quotes), FIELD(\'opportunity\' \'quotedAmount\'), 0), 0)) AS quotedAmount, SUM(if(leadSubject INSTANCE OF ZesharCRMCoreBundle:Opportunity, if(FIELD(\'opportunity\' \'id\') IN (:quotes), if(FIELD(\'opportunity\' \'priority\') = (:priorityHigh), 1, 0), 0), 0)) AS priorityHigh, SUM(if(leadSubject INSTANCE OF ZesharCRMCoreBundle:Opportunity, if(FIELD(\'opportunity\' \'id\') IN (:quotes), if(FIELD(\'opportunity\' \'priority\') = (:priorityMedium), 1, 0), 0), 0)) AS priorityMedium, SUM(if(leadSubject INSTANCE OF ZesharCRMCoreBundle:Opportunity, if(FIELD(\'opportunity\' \'id\') IN (:quotes), if(FIELD(\'opportunity\' \'priority\') = (:priorityLow), 1, 0), 0), 0)) AS priorityLow, SUM(if(leadSubject INSTANCE OF ZesharCRMCoreBundle:Lead, if(FIELD(\'lead\' \'id\') IN (:leads), if(FIELD(\'lead\' \'type\') = (:cold), 1, 0), 0), 0)) AS leadCold, SUM(if(leadSubject INSTANCE OF ZesharCRMCoreBundle:Lead, if(FIELD(\'lead\' \'id\') IN (:leads), if(FIELD(\'lead\' \'type\') = (:warm), 1, 0), 0), 0)) AS leadWarm, SUM(if(leadSubject INSTANCE OF ZesharCRMCoreBundle:Lead, if(FIELD(\'lead\' \'id\') IN (:leads), if(FIELD(\'lead\' \'type\') = (:hot), 1, 0), 0), 0)) AS leadHot, SUM(if(op.operationType = (:typeSold), 1, 0)) AS sold, SUM(if(op.operationType = (:typeLead), 1, 0)) AS lead, SUM(if(op.operationType = (:typeOppToLead), 1, 0)) AS typeOppToLead, SUM(if(op.operationType = (:typeQuoteToOpp), 1, 0)) AS typeQuoteToOpp, SUM(if(op.operationType = (:typeOpportunity), 1, 0)) AS opportunity, SUM(if(op.operationType = (:typeQuote), 1, 0)) AS quote')
            ->from('ZesharCRMCoreBundle:LeadSubject', 'leadSubject')
            ->leftJoin('leadSubject.milestoneOperations', 'op', 'WITH', 'op.id IN (:operations)')
            ->leftJoin('leadSubject.'.$propertyTitle, 'childEntity')
            ->orderBy('op.performedAt', 'DESC')
            ->groupBy('childEntity.id')
            ->setParameters(array(
                'cold' => LeadType::COLD,
                'warm' => LeadType::WARM,
                'hot' => LeadType::HOT,
                'priorityHigh' => OpportunityPriority::HIGH,
                'priorityMedium' => OpportunityPriority::MEDIUM,
                'priorityLow' => OpportunityPriority::LOW,
                'typeSold' => MilestoneOperationType::SOLD,
                'typeLead' => MilestoneOperationType::NEW_LEAD,
                'typeOppToLead' => MilestoneOperationType::OPPORTUNITY_TO_LEAD,
                'typeQuoteToOpp' => MilestoneOperationType::QUOTE_TO_OPPORTUNITY,
                'typeOpportunity' => MilestoneOperationType::LEAD_TO_OPPORTUNITY,
                'typeQuote' => MilestoneOperationType::OPPORTUNITY_TO_QUOTE,
                'operations' => $operations,
                'leads' => $leads,
                'quotes' => $quotes,
                'lostQuotes' => $lostQuotes,
                ))
        ;

//        SUM(if(leadSubject INSTANCE OF ZesharCRMCoreBundle:Lead, if(leadSubject.type = (:cold), 1, 0), 0)) AS leadCold,

        $result = $qb->getQuery()->getResult();
     //   print_r($result);die;

        return $result;


    }
}