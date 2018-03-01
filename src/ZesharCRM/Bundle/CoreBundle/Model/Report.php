<?php

namespace ZesharCRM\Bundle\CoreBundle\Model;

use ZesharCRM\Bundle\CoreBundle\Entity\User;
use ZesharCRM\Bundle\CoreBundle\Entity\LeadSource;
use Doctrine\ORM\EntityManager;
use ZesharCRM\Bundle\CoreBundle\Enum\ConversionType;
use ZesharCRM\Bundle\CoreBundle\Enum\OperationType;
use ZesharCRM\Bundle\CoreBundle\Enum\LeadType;
use ZesharCRM\Bundle\CoreBundle\Enum\OpportunityStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\DealStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\GoalKind;


class Report
{


    protected $container;

    public function __construct($container){
        $this->container = $container;
    }


    public function getTransition(){

    }

    public function getLeadReport($user = null){

        $header = array(
          'user' => 'User',
          'coldlead' => 'Cold Leads',
          'warmlead' => 'Warm Leads',
          'opportunities' => 'Opportunities (leads)',
          'quotes' => 'Quotes (leads)',
          'sold' => 'Sales (leads)',
        );

        $currentUser = $this->container->get('security.context')->getToken()->getUser();
        $company = $currentUser->getCompany();

        $em = $this->container->get('doctrine.orm.entity_manager');

        $users = $user ? $em->getRepository('ZesharCRMCoreBundle:User')->findById($user) : $em->getRepository('ZesharCRMCoreBundle:User')->findBy(array('company' => $company->getId()));

        $data = array();
        foreach($users as $user){
            $data[] = $this->getStatsByUser($user);
        }


        $totalNeeded = $header;
        unset($totalNeeded['user']);

        $data = $this->addTotal($data, array_keys($totalNeeded), array_keys($header));


        return array('header' => $header, 'data' => $data);
    }


    public function getConversionReport($user = null){

        $header = array(
          'user' => 'User',

          ConversionType::QUOTES_CONVERSION_RATE => 'Closing (items)',
          ConversionType::OPPORTUNITY_CONVERSION_RATE => 'Quoting (items)',
          ConversionType::WARM_LEADS_CONVERSION_RATE => 'Opportunity (leads)',
          ConversionType::COLD_LEADS_CONVERSION_RATE => 'Warming (leads)',
        );

        $conv = $this->container->get('zeshar_crm_core.admin.conversion');
        $data = $conv->getConversion();
        $totalNeeded = $header;
        unset($totalNeeded['user']);

        $data = $this->addTotal($data, array_keys($totalNeeded), array_keys($header));

        $data = $this->recalcQuotingAndClosing($data);

        return array('header' => $header, 'data' => $data);
    }

    private function recalcQuotingAndClosing($data) {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $operationsRepo = $em->getRepository('ZesharCRMCoreBundle:Operation');
        $i = 0;
        $totalClosing = 0;
        $totalQuoting = 0;
        while ($i < count($data) - 1) {
            $qouting = $operationsRepo->calcQuotingRate($data[$i]['user']);
            $data[$i][2] = $qouting === 'N/A' ? $qouting : $qouting.'%';
            $totalQuoting += $qouting;
            $closing = $operationsRepo->calcClosingRate($data[$i]['user']);
            $data[$i][1] = $closing === 'N/A' ? $closing : $closing.'%';
            $totalClosing += $closing;
            $i++;
        }
        $data[$i][1] = $totalClosing/$i;
        $data[$i][2] = $totalQuoting/$i;
        return $data;
    }

    public function getActivityReport(){


        $repository = $this->container->get('doctrine.orm.entity_manager')->getRepository('ZesharCRMCoreBundle:Activity')->getUserActivityData($user);

        return $this->container->get('templating')->render('ZesharCRMCoreBundle:Widget:activity.html.twig', array('data' => $repository, 'persons' => $persons, 'selectedUser' => $user->getUsername()));
    }

    private function division ($current, $total)
    {
        return ($total == 0) ? 0 : $current/$total;
    }

    protected function getStatsByUser($user){
        $em = $this->container->get('doctrine.orm.entity_manager');
        $operations= $em->getRepository('ZesharCRMCoreBundle:Operation')->getClearOperationData($user);
        $performance = OperationType::getEmptyOperationArray();
        foreach ($operations as $operation) {
            $type = $operation->getOperationType();
            $performance[$type]++;
        }

        $leads = $em->getRepository('ZesharCRMCoreBundle:Lead')->findBy(array('assignee' => $user, 'type' => LeadType::COLD,'status' => DealStatus::PENDING));
        $warmLeads = $em->getRepository('ZesharCRMCoreBundle:Lead')->findBy(array('assignee' => $user, 'type' => LeadType::WARM, 'status' => DealStatus::PENDING));
        $opportunity = $em->getRepository('ZesharCRMCoreBundle:Opportunity')->findBy(array('assignee'=>$user, 'status'=>OpportunityStatus::PENDING_OPPORTUNITY));
        $quote = $em->getRepository('ZesharCRMCoreBundle:Opportunity')->findBy(array('assignee'=>$user, 'status'=>OpportunityStatus::PENDING_QUOTE));

        $totalColdLead = (count($leads)+$performance[OperationType::CANCELLED_LEAD]+$performance[OperationType::COLD_TO_WARM_LEAD]);
        $totalWarmLead = (count($warmLeads)+$performance[OperationType::CANCELLED_LEAD]+$performance[OperationType::LEAD_TO_OPPORTUNITY]);
        $totalOpportunity = (count($opportunity)+$performance[OperationType::CANCELLED_OPPORTUNITY]+$performance[OperationType::OPPORTUNITY_TO_QUOTE]);
        $totalQuote = (count($quote)+$performance[OperationType::CANCELLED_QUOTE]);
        $totalSold = ($performance[OperationType::SUCCESS_QUOTE]);

        return array(
            'user' => $user->getUsername(),
            'coldlead' => $totalColdLead,
            'warmlead' => $totalWarmLead,
            'opportunities' => $totalOpportunity,
            'quotes' => $totalQuote,
            'sold' => $totalSold,
        );
    }

    protected function addTotal($data, $fields, $header){
        $total = array();

        $index = count($data);
        foreach($fields as $field){
            $total[$field] = array_sum(array_map(function($row) use ($field){
                  return $row[$field];
              }, $data));
        }

        $set = array();
        foreach($header as $field){
            $set[$field] = isset($total[$field]) ? $total[$field]/$index:'';
        }
        $data[] = $set;
        return $data;
    }

    public function getFrom(){
        return $this->getParam('from');
    }

    public function getTo(){
        return $this->getParam('to');
    }


    protected  function getParam($name){
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->container->get('doctrine.orm.entity_manager');
        if($em->getFilters()->isEnabled('date_range_filter')){
            try{
                $param = $em->getFilters()->getFilter('date_range_filter')->getParameter($name);
            }
            catch(\InvalidArgumentException $e){
                $param = null;
            }

            if($param){
                $date = \DateTime::createFromFormat('\'Y-m-d H:i:s\'', $param);
                return $date->format('M d, Y');
            }
        }
        return '';
    }

    public function getAuditReport()
    {
        /** @var $em EntityManager */
        $em = $this->container->get('doctrine.orm.entity_manager');

        $users = $em->getRepository('ZesharCRMCoreBundle:User')->findAll();

        $result = array();

        /** @var $user User */
        foreach ($users as $user) {
            $username = $user->getUsername();

            $leads = $em->getRepository('ZesharCRMCoreBundle:Lead')->findBy(array('assignee' => $user, 'status' => DealStatus::PENDING));
            $pendingOpportunities = $em->getRepository('ZesharCRMCoreBundle:Opportunity')->findBy(array('assignee'=>$user, 'status'=>OpportunityStatus::PENDING_OPPORTUNITY));
            $opportunities = $em->getRepository('ZesharCRMCoreBundle:Opportunity')->findBy(array('assignee'=>$user));
            $quotes = $em->getRepository('ZesharCRMCoreBundle:Opportunity')->findBy(array('assignee'=>$user, 'status'=>OpportunityStatus::PENDING_QUOTE));
            $sales = $em->getRepository('ZesharCRMCoreBundle:Opportunity')->findBy(array('assignee'=>$user, 'status'=>OpportunityStatus::SUCCESS_QUOTE));
            $lostOpportunities = $em->getRepository('ZesharCRMCoreBundle:Opportunity')->findBy(array('assignee'=>$user, 'status' => OpportunityStatus::CANCELLED_OPPORTUNITY));
            $leadWarm = $em->getRepository('ZesharCRMCoreBundle:Lead')->findBy(array('assignee' => $user, 'status' => DealStatus::PENDING, 'type' => LeadType::WARM));
            $leadHot = $em->getRepository('ZesharCRMCoreBundle:Lead')->findBy(array('assignee' => $user, 'status' => DealStatus::PENDING, 'type' => LeadType::HOT));
            $leadCold = $em->getRepository('ZesharCRMCoreBundle:Lead')->findBy(array('assignee' => $user, 'status' => DealStatus::PENDING, 'type' => LeadType::COLD));

            $sources = $em->getRepository('ZesharCRMCoreBundle:LeadSource')->findAll();

            /** @var $source LeadSource */
            foreach ($sources as $source) {
                $leadSources = $em->getRepository('ZesharCRMCoreBundle:Lead')->findBy(array('assignee' => $user, 'status' => DealStatus::PENDING, 'leadSource' => $source));
                $result[$username]['leadSources'][$source->getTitle()] = count($leadSources);
            }

            $result[$username]['countLeads'] = count($leads);
            $result[$username]['countOpportunities'] = count($opportunities);
            $result[$username]['countPendingOpportunities'] = count($pendingOpportunities);
            $result[$username]['countLostOpportunities'] = count($lostOpportunities);
            $result[$username]['leadStatusWarm'] = count($leadWarm);
            $result[$username]['leadStatusHot'] = count($leadHot);
            $result[$username]['leadStatusCold'] = count($leadCold);
            $result[$username]['quotes'] = count($quotes);
            $result[$username]['sales'] = count($sales);
        }

        $header = array(
            'user' => 'User',
            'totalLeads' => 'Total Leads',
            'opportunities' => 'Opportunities',
            'pendingOpportunities' => 'Pending Opportunities',
            'lostOpportunities' => 'Lost Opportunities',
            'leadsBySource' => 'Leads – by source',
            'leadsByStatus' => 'Lead By Status',
            'warm' => 'Warm'
        );
    }

}
