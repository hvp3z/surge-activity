<?php

namespace ZesharCRM\Bundle\GoalsBundle\Service\Widget;

use Symfony\Component\DependencyInjection\ContainerInterface;
use ZesharCRM\Bundle\CoreBundle\Enum\LeadType;
use ZesharCRM\Bundle\CoreBundle\Enum\OperationType;
use ZesharCRM\Bundle\CoreBundle\Enum\OpportunityStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\DealStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\GoalKind;
use ZesharCRM\Bundle\CoreBundle\Model\Report;
use ZesharCRM\Bundle\GoalsBundle\Service\Widget\WidgetCalculator;
use ZesharCRM\Bundle\CoreBundle\Enum\GoalStatus;
use ZesharCRM\Bundle\CoreBundle\Repository\WidgetRepository;
use ZesharCRM\Bundle\CoreBundle\Repository\OperationRepository;

class NeedWidget extends CommonWidget
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function render($user,$persons)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $isAll = WidgetRepository::isShowAllData($user);

        $goalOpen = $this->container->get('doctrine.orm.entity_manager')->getRepository('ZesharCRMGoalsBundle:GoalAssignment')->assignGoal($user);
        $goalOpen = WidgetCalculator::getGoalMonth($goalOpen, $user);

        /** @var $operationRepository OperationRepository */
        $operationRepository = $em->getRepository('ZesharCRMCoreBundle:Operation');

        $total = array('estimated' => 0,'current' => 0);
        $reportBuilder =  new Report($this->container);
        $report = $reportBuilder->getConversionReport();
        $conversionRate = null;
        foreach ($goalOpen as $key1=>$value1) {
            if($isAll){
                $conversionRate = $report['data'][count($report['data'])-1];
                $total['estimated'] += $value1['estimated'];
            } else {
                $conversionRate = $this->findRateInReportByUserId($report, $this->container->get('security.context')->getToken()->getUser()->getId());
                $goalAssignment = $em->getRepository('ZesharCRMGoalsBundle:GoalAssignment')->findOneBy(array('id' => $value1['id']));
                $goalAssign = $em->getRepository('ZesharCRMGoalsBundle:GoalAssign')->findOneBy(array('goal' => $goalAssignment->getGoal(), 'user' => $user));
                $total['estimated'] += round($goalAssign->getItems());
            }
        }
        $total['current'] = 0;
        $leads = $operationRepository->getAllLeadsByOperation(OperationType::SUCCESS_QUOTE, ($isAll ? null : null));
        foreach ($leads as &$lead) {
            $total['current'] += $lead['lead']->getQuantity();
        }


        $needSales = array();
        $needSales['count'] = $total['estimated'] - $total['current'];
        $needSales['percent'] = $this->division($total['current'], $total['estimated']);
        $needSales['color'] = '35b16f';

        $result = array();
        $result['Sales'] = $needSales;

        // for Quotes
        $total = round(self::division($needSales['count'], $conversionRate[1]/100));
        $leads = $operationRepository->getAllLeadsByOperation(OperationType::OPPORTUNITY_TO_QUOTE, ($isAll ? null : null));
        $current = 0;
        foreach ($leads as &$lead) {
            $current += $lead['lead']->getQuantity();
        }
        //
        $result['Quotes'] = array(
            'count' => $total - $current,
            'percent' => self::division($current, $total),
            'color' => '3393ff'
        );

        // for Opportunities
        $total = round(self::division($result['Quotes']['count'], $conversionRate[2]/100));
        $current = count($operationRepository->getAllLeadsByOperation(OperationType::LEAD_TO_OPPORTUNITY, ($isAll ? null : null)));
        //
        $result['Opportunities'] = array(
            'count' => $total - $current,
            'percent' => self::division($current,$total),
            'color' => 'd62020');

        // for Warm Leads
        $total = round(self::division($result['Opportunities']['count'], $conversionRate[3]/100));
        $current = count($operationRepository->getAllLeadsByOperation(OperationType::COLD_TO_WARM_LEAD, ($isAll ? null : null)));
        //
        $result['Warm Leads'] = array(
            'count' => $total- $current,
            'percent' => self::division($current,$total),
            'color' => 'a7d40b');

        // for Cold Leads
        $total = round(self::division ($result['Warm Leads']['count'], $conversionRate[4]/100)) ;
        $current = count($operationRepository->getAllLeadsByOperation(OperationType::COLD_LEAD, ($isAll ? null : null)));
        //
        $result['Cold Leads'] = array(
            'count' => $total - $current,
            'percent' => self::division($current, $total),
            'color' => 'e86107');

        $result = array_reverse($result);
        return $this->container->get('templating')->render('ZesharCRMGoalsBundle:Widget:need.html.twig', array('data' => $result, 'persons' => $persons, 'selectedUser' => $user->getUsername()));
    }


    private function division ($current, $total)
    {
        return ($total == 0) ? 0 : $current/$total;
    }

    private function findRateInReportByUserId($report, $userId)
    {
        foreach ($report['data'] as $convRate) {
            if ($convRate['user']->getId() === $userId) {
                return $convRate;
            }
        }
        return null;
    }

}
