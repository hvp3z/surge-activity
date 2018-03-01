<?php

namespace ZesharCRM\Bundle\GoalsBundle\Service\Widget;

use ZesharCRM\Bundle\CoreBundle\Enum\GoalStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\OperationType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ZesharCRM\Bundle\GoalsBundle\Service\Widget\WidgetCalculator;
class PerformanceWidget extends CommonWidget
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function render($user,$persons)
    {
        $performance = array();
        $result = array();

        $company = $user->getCompany();

        $em = $this->container->get('doctrine.orm.entity_manager');

        $goalOpen = $em->getRepository('ZesharCRMGoalsBundle:GoalAssignment')->assignGoal($user);

        if (!empty($goalOpen)) {
            $performance = WidgetCalculator::getGoalMonth($goalOpen, $user);
        }

        $users = $this->getAllUsersExceptAdmin($this->container->get('doctrine.orm.entity_manager'));
        $usersNumber = count($users);

        foreach ($performance as $key => $value) {
            if(self::isAdmin($user)){
                $estimated = round($value['estimated']);
            }else{
                $goalAssignment = $em->getRepository('ZesharCRMGoalsBundle:GoalAssignment')->findOneBy(array('id' => $value['id']));
                $goalAssign = $em->getRepository('ZesharCRMGoalsBundle:GoalAssign')->findOneBy(array('goal' => $goalAssignment->getGoal(), 'user' => $user));
                $estimated = round($goalAssign->getItems());
            }

            $percent = round(self::division($value['current'],$estimated)*100);

            if($percent > 100) {
                $resultPercent = 100;
            } else {
                $resultPercent = $percent;
            }

            $result [$key] = array('value' => $resultPercent, 'title' => $value['title'] );
        }
        return $this->container->get('templating')->render('ZesharCRMGoalsBundle:Widget:performance.html.twig', array('data' => $result, 'persons' => $persons, 'selectedUser' => $user->getUsername()));
    }

    private function division ($current, $total)
    {
        return ($total == 0) ? 0 : $current/$total;
    }

    private function getAllUsersExceptAdmin($em, $company = null)
    {
        $allUsers = $em->getRepository('ZesharCRMCoreBundle:User')->findBy(array('company' => $company));
        $users = array();

        if($allUsers){
            foreach($allUsers as $key=>$user){
                $roles = $user->getRoles();
//                if(!in_array('ROLE_SUPER_ADMIN', $roles)){
                    $users[$key] = $user;
//                }
            }
        }

        return array_values($users);
    }

}
