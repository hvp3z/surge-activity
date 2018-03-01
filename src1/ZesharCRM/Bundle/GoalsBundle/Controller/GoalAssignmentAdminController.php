<?php

namespace ZesharCRM\Bundle\GoalsBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sonata\AdminBundle\Controller\CRUDController as CRUDController;
use ZesharCRM\Bundle\CoreBundle\Event\CustomEvent;
use ZesharCRM\Bundle\CoreBundle\Enum\GoalKind;


class GoalAssignmentAdminController extends CRUDController
{

    private function getRepository() {
        return $this->getDoctrine()->getRepository('ZesharCRM\Bundle\GoalsBundle\Entity\Goal');
    }

    public function checkAction()
    {
        $event = new CustomEvent();
        $event->setType(GoalKind::COLD_TO_WARM_LEAD);
        $dispatcher = $this->get('event_dispatcher');
        $dispatcher->dispatch('goal.check');
        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    public function showUserGoalAction()
    {
        $user = $this->getUser();
        $entities = $this->getDoctrine()->getRepository('ZesharCRMGoalsBundle:GoalAssignment')->yearUserGoal($user);
        $result = array();
        foreach ($entities as $entity) {
            if (!array_key_exists($entity->getGoal()->getGoalCategory()->getTitle(),$result)) {
                $result[$entity->getGoal()->getGoalCategory()->getTitle()]['estimated'] = 0;
                $result[$entity->getGoal()->getGoalCategory()->getTitle()]['percent'] = 0;

            }
            $result[$entity->getGoal()->getGoalCategory()->getTitle()]['estimated'] += $entity->getEstimated();
            $result[$entity->getGoal()->getGoalCategory()->getTitle()]['percent'] += $entity->getGoal()->getEstimated();
            $result[$entity->getGoal()->getGoalCategory()->getTitle()]['prev'] = $entity->getGoal()->getTotal();
            $result[$entity->getGoal()->getGoalCategory()->getTitle()]['points'] = $entity->getGoal()->getGoalCategory()->getPoints();
        }

        return  $this->render('ZesharCRMGoalsBundle:Goal:goal_show.html.twig', array(
            'result' => $result
        ));
    }
}
