<?php

namespace ZesharCRM\Bundle\GoalsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Validator\Constraints\DateTime;
use ZesharCRM\Bundle\CoreBundle\Entity\LeadCategory;
use ZesharCRM\Bundle\CoreBundle\Entity\User;
use ZesharCRM\Bundle\CoreBundle\Entity\LeadSource;
use ZesharCRM\Bundle\GoalsBundle\Entity\Goal;
use ZesharCRM\Bundle\GoalsBundle\Entity\GoalAssign;
use ZesharCRM\Bundle\GoalsBundle\Entity\GoalAssignment;
use ZesharCRM\Bundle\CoreBundle\Enum\GoalStatus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GoalGlobalAdminController extends Controller
{

    public function indexAction(Request $request)
    {
        $action = $request->get('action');
        $method = $action . 'Action';
        if (method_exists($this, $method)) {
            $this->getDoctrine()->getManager()->getFilters()->disable('lead_subject_filter');
            return $this->$method($request);
        } else {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }
    }

    public function showAdminGoalsAction()
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $roles = $user->getRoles();
        if(!in_array('ROLE_SUPER_ADMIN', $roles)){
            throw new NotFoundHttpException('Page not found');
        }

        $company = $user->getCompany();
        $qb = $em
            ->createQueryBuilder()
            ->select('l')
            ->from('ZesharCRMCoreBundle:LeadCategory', 'l')
            ->leftJoin('l.creator' , 'c')
            ->andWhere('c.company = :company')
            ->setParameters(array('company' => $company));
        $products = $qb->getQuery()->getResult();

        $result = array();
        /** @var $product LeadCategory */
        foreach($products as $product) {
            $title = $product->getTitle();
            /** @var $goal Goal */
            $goal = $em->getRepository('ZesharCRMGoalsBundle:Goal')->findOneBy(array('goalCategory' => $product));
            if ($goal) {
                $percent = $goal->getEstimated();
                $prev =  $goal->getTotal();
                $estimated = round( ($percent/100 + 1) * $prev  , 2);

            } else {
                $percent = 0;
                $prev =  0;
                $estimated = 0;
            }
            $result[$title]['percent'] = $percent;
            $result[$title]['prev'] = $prev;
            $result[$title]['points'] = $product->getPoints();
            $result[$title]['estimated'] = $estimated;
            $result[$title]['productId'] = $product->getId();

        }

        $admin_pool = $this->get('sonata.admin.pool');

        return  $this->render('ZesharCRMGoalsBundle:CRUD:goal_list.html.twig', array(
            'result' => $result,
            'admin_pool' => $admin_pool,
        ));
    }

    public function showAdminGoalAction($id)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $users = $em->getRepository('ZesharCRMCoreBundle:User')->findBy(array('company' => $user->getCompany()));
        $weHaveUsers = false;
        if($users){
            /** @var $user User */
            foreach ($users as $key=>$user) {
//                if (!($user->isSuperAdmin())){
                    $weHaveUsers = true;
//                }
            }
        }

        if($weHaveUsers){

            /** @var $product LeadCategory */
            $product = $em->getRepository('ZesharCRMCoreBundle:LeadCategory')->find($id);

            /** @var $goal Goal */
            $goal = $em->getRepository('ZesharCRMGoalsBundle:Goal')->findOneBy(array('goalCategory' => $product));

            $result = array();

            $goalsAssignee = $em->getRepository('ZesharCRMGoalsBundle:GoalAssign')->findBy(array('goal' => $goal));

            $existingUsers = array();

            $globalPercent = $goal->getEstimated();
            $prev =  $goal->getTotal();
            $globalEstimated = round(($globalPercent/100 + 1) * $prev, 2);
            $productPoints = $product->getPoints();
            $points = $globalEstimated*$productPoints;

            $distributedPoints = 0;
            $distributedPercent = 0;
            $distributedItems = 0;

            if ($goalsAssignee) {
                /** @var $goalAssignee GoalAssign */
                foreach ($goalsAssignee as $key=>$goalAssignee) {
                    $goalUser = $goalAssignee->getUser();
//                    if ( $goalUser->isSuperAdmin()) {
//                        unset($goalsAssignee[$key]);
//                        continue;
//                    }
                    //if
                    $existingUsers[] = $goalUser;

                    $username = $goalUser->getUsername();

                    $distributedPoints += $goalAssignee->getPoint();
                    $distributedPercent += $goalAssignee->getPercent();
                    $distributedItems += $goalAssignee->getItems();

                    $result[$username]['point'] = $goalAssignee->getPoint();
                    $result[$username]['percent'] = $goalAssignee->getPercent();
                    $result[$username]['items'] = $goalAssignee->getItems();
                    $result[$username]['id'] = $goalUser->getId();
                }
            } else {
                /** @var $user User */
                foreach ($users as $key=>$user) {

                    if (array_search($user, $existingUsers, true) /*|| $user->isSuperAdmin()*/) {
                        unset($users[$key]);
                        continue;
                    }
                }

                $remainingUsers = count($users) - count($goalsAssignee);
                $remainingPoints = $points - $distributedPoints;

                $point = $remainingPoints / $remainingUsers;
                $items = ($globalEstimated - $distributedItems) / $remainingUsers;
                $percent = (100 - $distributedPercent) / $remainingUsers;

                foreach ($users as $user) {
                    $username = $user->getUsername();

                    $result[$username]['point'] = round($point, 2);
                    $result[$username]['percent'] = round($percent, 2);
                $result[$username]['items'] = round($items, 2);
                    $result[$username]['id'] = $user->getId();
                }
            }

            $data['goalEstimated'] = $globalEstimated;
            $data['productPoints'] = $product->getPoints();
            $data['productTitle'] = $product->getTitle();
            $data['users'] = $result;
            $data['globalPercent'] = $globalPercent;
            $data['globalPoints'] = $points;
            $data['goalId'] = $goal->getId();
        }else{
            $data = array(
                'goalEstimated' => 0,
                'productPoints' => 0,
                'productTitle' => '',
                'users' => array(),
                'globalPercent' => 0,
                'globalPoints' => 0,
                'goalId' => null,
            );
        }

        $admin_pool = $this->get('sonata.admin.pool');

        return  $this->render('ZesharCRMGoalsBundle:CRUD:goal.html.twig', array(
            'data' => $data,
            'admin_pool' => $admin_pool,
        ));
    }

    public function updateGoalAction(Request $request)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $params = $request->request->all();

        $result = array();

        if (isset($params['product_id'])) {

            /** @var $product LeadCategory */
            $product = $em->getRepository('ZesharCRMCoreBundle:LeadCategory')->find($params['product_id']);

            $prev = (int) $params['prev'];
            $percent = (int) $params['percent'];
            $estimated = round(($percent/100 + 1) * $prev, 2);

            $result['percent'] = $percent;
            $result['prev'] = $prev;
            $result['points'] = $product->getPoints();
            $result['estimated'] = $estimated;
        }

        $response = new JsonResponse();
        $response->setData($result);

        return $response;

    }

    public function saveGoalsAction(Request $request)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $params = $request->request->all();

        foreach ($params as $param) {
            if (isset($param['product_id'])) {

                /** @var $product LeadCategory */
                $product = $em->getRepository('ZesharCRMCoreBundle:LeadCategory')->find($param['product_id']);

                /** @var $goal Goal */
                $goal = $em->getRepository('ZesharCRMGoalsBundle:Goal')->findOneBy(array('goalCategory' => $product));

                if (!$goal) {
                    $goal = new Goal();
                    $goal->setGoalCategory($product);
                    $startsAt = new \DateTime();
                    $startsAt->setTime(0, 0, 0);
                    $startsAt->modify('first day of january ' . $startsAt->format('Y'));
                    $goal->setStartsAt($startsAt);
                    $finishesAt =  new \DateTime();
                    $finishesAt->setTime(0, 0, 0);
                    $finishesAt->modify('last day of december' . $startsAt->format('Y'));
                    $goal->setFinishesAt($finishesAt);
                    $goal->setCreator($this->getUser());
                }

                $goal->setTotal($param['prev']);
                $goal->setEstimated($param['percent']);

                $em->persist($goal);
                $em->flush();

//                if((int)$param['percent'] != 0){
//                    $sales = $this->getDoctrine()->getRepository('ZesharCRMCoreBundle:User')->findByRole('ROLE_SALES_PERSON');
//                    $params = array();
//                    if($sales){
//                        foreach($sales as $sale){
//                            $goalAss = $this->getDoctrine()->getRepository('ZesharCRMGoalsBundle:GoalAssign')->findBy(array('user' => $sale->getId(), 'goal' => $goal->getId()));
//                            if(!$goalAss){
//                                $params[$sale->getId()] = array(
//                                    'points' => '0',
//                                    'percent' => '0',
//                                    'items' => '0'
//                                );
//                            }
//                        }
//                        if(!$goalAss){
//                            $params['goalId'] = $goal->getId();
//                            $this->saveGoalAssignsAction($request, $params);
//                        }
//                    }
//                }
            }
        }

        return new JsonResponse();
    }

    public function saveGoalAssignsAction(Request $request , $params = null)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        if(!$params){
            $params = $request->request->all();
        }

        /** @var $goal Goal */
        $goal = $em->getRepository('ZesharCRMGoalsBundle:Goal')->find($params['goalId']);

        foreach ($params as $userId => $goalAssign) {
           //
            /** @var $user User */
                $user = $em->getRepository('ZesharCRMCoreBundle:User')->find($userId);
            $goalsAssignee = $em->getRepository('ZesharCRMGoalsBundle:GoalAssign')->findOneBy(array('goal' => $goal, 'user' => $user));

            if (!$goalsAssignee) {
                $goalsAssignee = new GoalAssign();
                $goalsAssignee->setUser($user);
                $goalsAssignee->setGoal($goal);
            }

           // print_r((float) $goalAssign['percent']);die;
            if (!isset($goalAssign['percent']) || !isset($goalAssign['points']) || !isset($goalAssign['items'])) {
                continue;
            }
            $goalsAssignee->setPercent((float) $goalAssign['percent']);
            $goalsAssignee->setPoint((float) $goalAssign['points']);
            $goalsAssignee->setItems((float) $goalAssign['items']);

            $em->persist($goalsAssignee);

            $count = 1;
            $estimated = ($goal->getTotal()/$count+$goal->getTotal()/100*$goal->getEstimated())/count($user);
            $goalAssignment = $em->getRepository('ZesharCRMGoalsBundle:GoalAssignment')->findOneBy(array('goal' => $goal, 'assignee' => $user));
            if(!$goalAssignment) {
                $goalAssignment = new GoalAssignment();
            }

            $current = $goalAssignment->getCurrent() ? $goalAssignment->getCurrent() : 0;

            $goalAssignment->setGoal($goal);
            $goalAssignment->setCurrent($current);
            $goalAssignment->setEstimated($estimated);
            $goalAssignment->setStatus(GoalStatus::OPEN);
            $goalAssignment->setAssignee($user);
            $em->persist($goalAssignment);
            $em->flush($goalAssignment);
            unset($goalAssignment);

        }
        $em->flush();

        return new JsonResponse();
    }

    public function showAdminGoalReportAction()
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $strStartDay = $this->get('zeshar_crm_core.admin.report_manager')->getFrom();
        $strFinishDay = $this->get('zeshar_crm_core.admin.report_manager')->getTo();



        $users = $em->getRepository('ZesharCRMCoreBundle:User')->findAll();

        $result = array();

        $currentMonth = (int) date('m');
        $currentYear = (int) date('Y');

        //print_r($strStartDay);die;

        if (!$strFinishDay && !$strStartDay) {
            $currentDay = (int) date('d');
            $filter = false;
        } else {
            $filter = true;
            if ($strStartDay) {
                $startDay = \DateTime::createFromFormat('M d, Y', $strStartDay);
            } else {
                $strStartDay = date('Y-m-d', strtotime('first day of January this year'));
                $startDay = \DateTime::createFromFormat('Y-m-d', $strStartDay);
            }
            if ($strFinishDay) {
                $finishDay = \DateTime::createFromFormat('M d, Y', $strFinishDay);
            } else {
                $strFinishDay = date('Y-m-d', strtotime('last day of December this year'));

                $finishDay = \DateTime::createFromFormat('Y-m-d', $strFinishDay);
            }

            $currentDay = $finishDay->diff($startDay)->format("%a");
//            if ($finishDay == $startDay) {
//                $currentDay = 1;
//            } else {
//                $currentDay = $finishDay->diff($startDay)->format("%a");
//            }
            //print_r($currentDay);die;
        }



        $countDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

        /** @var $user User */
        foreach ($users as $user) {

            if ($user->isSuperAdmin()) {
                continue;
            }

            $username = $user->getUsername();

            $userGoals = $em->getRepository('ZesharCRMCoreBundle:Operation')->getSoldGoalsGroupProductByDate($user, $currentMonth, $currentYear);

            $summaryItems = 0;
            $summaryCampaignCount = 0;
            $summarySourceCount = 0;
            $summarySold = 0;
            $summaryPerformance = 0;
            $summaryPercentPreMonths = array();

            foreach ($userGoals as $userGoal) {
                $result['users'][$username]['products'][$userGoal['title']]['user_year_goal'] = $userGoal['items'];
                $result['users'][$username]['products'][$userGoal['title']]['sold'] = $userGoal['soldItems' . $currentMonth];
                $result['users'][$username]['products'][$userGoal['title']]['campaignCount'] = $userGoal['campaignCount'];
                $result['users'][$username]['products'][$userGoal['title']]['sourceCount'] = $userGoal['sourceCount'];

                $percentPreMonths = array();


                for ($i = 1; $i < $currentMonth; $i++) {

                    $dateObj = \DateTime::createFromFormat('!m', $i);
                    $monthName = $dateObj->format('F');
                    if (!isset($summaryPercentPreMonths[$monthName])) {
                        $summaryPercentPreMonths[$monthName] = $userGoal['soldItems' . $i];
                    } else {
                        $summaryPercentPreMonths[$monthName] += $userGoal['soldItems' . $i];
                    }

                    $percentPreMonths[$monthName] = $userGoal['soldItems' . $i];
                }

                $result['users'][$username]['products'][$userGoal['title']]['percentPreMonths'] = $percentPreMonths;

                $summaryItems += $userGoal['items'];
                $summaryCampaignCount += $userGoal['campaignCount'];
                $summarySourceCount += $userGoal['sourceCount'];
                $summarySold += $userGoal['soldItems' . $currentMonth];
            }

//            print_r($summaryCampaignCount);
//            print_r($summarySourceCount);die;

            $summaryItems = round($summaryItems/12, 2);

            $summaryCurrentGoals = $currentDay / $countDaysInMonth * $summaryItems;

            if ($summaryCurrentGoals != 0) {
                $summaryPerformance = $summarySold/$summaryCurrentGoals * 100;
            }

            if ($summarySold != 0) {
                $summaryCampaignPercent = $summaryCampaignCount/$summarySold * 100;
                $summarySourcePercent = $summarySourceCount/$summarySold * 100;
            } else {
                $summaryCampaignPercent = 0;
                $summarySourcePercent = 0;
            }

            $result['users'][$username]['summaryItems'] = $summaryItems;
            $result['users'][$username]['id'] = $user->getId();
            $result['users'][$username]['summaryCampaignPercent'] = round($summaryCampaignPercent, 2);
            $result['users'][$username]['summarySourcePercent'] = round($summarySourcePercent, 2);
            $result['users'][$username]['summaryPercentPreMonths'] = $summaryPercentPreMonths;
            $result['users'][$username]['summarySold'] = $summarySold;
            $result['users'][$username]['summaryCurrentGoals'] = round($summaryCurrentGoals, 2);
            $result['users'][$username]['summaryPerformance'] = round($summaryPerformance, 2);
            $result['countDaysInMonth'] = $countDaysInMonth;
            $result['currentDay'] = $currentDay;
        }//die;

         // print_r($result);die;

        $admin_pool = $this->get('sonata.admin.pool');

        $reportManager = $this->get('zeshar_crm_core.admin.report_manager');

        return  $this->render('ZesharCRMGoalsBundle:CRUD:goal_report.html.twig', array(
            'result' => $result,
            'filter' => $filter,
            'admin_pool' => $admin_pool,
            'rangeFrom' => $reportManager->getFrom(),
            'rangeTo' => $reportManager->getTo(),
        ));
    }

    public function childEntityTableGenerateAction($userId, $propertyTitle, $entityTitle)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('ZesharCRMCoreBundle:User')->find($userId);

        $result = array();

        $reportManager = $this->get('zeshar_crm_core.admin.report_manager');

        $currentMonth = (int) date('m');
        $currentYear = (int) date('Y');

        $childEntities = $em->getRepository('ZesharCRMCoreBundle:MilestoneOperation')->getChildEntityByUserAndDate($user, $currentMonth, $currentYear, $propertyTitle);

        foreach ($childEntities as $childEntity) {


            if (!isset($childEntity['id']) || empty($childEntity['id']))
            {
                continue;
            }

            $result['entity'][$childEntity['title']]['sold'] = $childEntity['sold'];
            $result['entity'][$childEntity['title']]['lost'] = $childEntity['typeOppToLead'] + $childEntity['typeQuoteToOpp'];
            $result['entity'][$childEntity['title']]['opportunity'] = $childEntity['opportunity'];
            $result['entity'][$childEntity['title']]['quote'] = $childEntity['quote'];
            $result['entity'][$childEntity['title']]['lead'] = $childEntity['lead'];
            $result['entity'][$childEntity['title']]['leadCold'] = $childEntity['leadCold'];
            $result['entity'][$childEntity['title']]['leadWarm'] = $childEntity['leadWarm'];
            $result['entity'][$childEntity['title']]['leadHot'] = $childEntity['leadHot'];
            $result['entity'][$childEntity['title']]['priorityHigh'] = $childEntity['priorityHigh'];
            $result['entity'][$childEntity['title']]['priorityMedium'] = $childEntity['priorityMedium'];
            $result['entity'][$childEntity['title']]['priorityLow'] = $childEntity['priorityLow'];
            $result['entity'][$childEntity['title']]['quotedAmount'] = $childEntity['quotedAmount'];
            $result['entity'][$childEntity['title']]['lostQuotedAmount'] = $childEntity['lostQuotedAmount'];
        }

        $admin_pool = $this->get('sonata.admin.pool');
        $reportManager = $this->get('zeshar_crm_core.admin.report_manager');

        return $this->render('ZesharCRMGoalsBundle:CRUD:goal_report_child_table.html.twig', array(
            'entityTitle' => $entityTitle,
            'data' => $result,
            'admin_pool' => $admin_pool,
            'rangeFrom' => $reportManager->getFrom(),
            'rangeTo' => $reportManager->getTo(),
        ));
    }

    public function campaignTableGenerateAction()
    {
        return new JsonResponse();
    }

    private function getLoggedInUser()
    {
        if ($user = $this->container->get('security.context')->getToken()->getUser()) {
            return $user;
        }
        return NULL;
    }


}