<?php
namespace ZesharCRM\Bundle\CoreBundle\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ZesharCRM\Bundle\CoreBundle\Event\CustomEvent;
use ZesharCRM\Bundle\CoreBundle\Enum\GoalStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\ActivityStatus;

class CESubscriber implements EventSubscriberInterface
{
    public $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'goal.increase' => array('increaseGoal', 0),
            'goal.check' => array('checkGoal', 0),
            'activity.check' => array('checkActivity', 0),
        );
    }

    public function increaseGoal()
    {
        // add $goal here
        $em = $this->container->get('doctrine.orm.entity_manager');
        $user = $this->container->get('security.context')->getToken()->getUser();

        $leadId = $this->container->get('service_container')->get('request')->request->get('lead');

        $lead = $em->getRepository('ZesharCRMCoreBundle:LeadSubject')->findOneBy(array('id' => $leadId));
        $leadCategory = $lead->getLeadCategory();

        $roles = $user->getRoles();
        if(in_array('ROLE_SUPER_ADMIN', $roles)){
            $user = $lead->getAssignee();
        }

        $goal = $em->getRepository('ZesharCRMGoalsBundle:Goal')->findOneBy(array('goalCategory' => $leadCategory->getId()));


        $entities = $em->getRepository('ZesharCRMGoalsBundle:GoalAssignment')->assignGoalByUser($user, $goal);
        foreach ($entities as $entity) {
            $quantity = $lead->getQuantity() ? $lead->getQuantity() : 1;
            $entity->setCurrent($entity->getCurrent() + $quantity);

            $goalAssignment = $em->getRepository('ZesharCRMGoalsBundle:GoalAssignment')->findOneBy(array('id' => $entity->getId()));
            $goalAssign = $em->getRepository('ZesharCRMGoalsBundle:GoalAssign')->findOneBy(array('goal' => $goalAssignment->getGoal(), 'user' => $user));

            if ($entity->getCurrent() == $goalAssign->getItems()) {
                $entity->setStatus(GoalStatus::SUCCESS_CLOSED);
            }
            $em->persist($entity);
        }
    }

    public function checkGoal()
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $entities = $em->getRepository('ZesharCRMGoalsBundle:GoalAssignment')->findFailGoal();
        foreach ($entities as $entity) {
            $entity->setStatus(GoalStatus::FAIL_CLOSED);
            $em->persist($entity);
        }
        $em->flush();
    }

    public function checkActivity()
    {
        $em = $this->container->get('doctrine.orm.entity_manager')->getRepository('ZesharCRMCoreBundle:Activity');
        $entities = $em->getExpiredActivity();
        foreach ($entities as $entity) {
            $em->transferActivity($entity);
        }
    }
}
