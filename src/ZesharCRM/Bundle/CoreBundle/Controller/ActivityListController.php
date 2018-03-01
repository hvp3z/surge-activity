<?php

namespace ZesharCRM\Bundle\CoreBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject;
use ZesharCRM\Bundle\CoreBundle\Entity\User;
use ZesharCRM\Bundle\CoreBundle\Entity\Activity;
use ZesharCRM\Bundle\CoreBundle\Repository\LeadRepository;


class ActivityListController extends Controller
{
    public function ajaxAction(Request $request)
    {
        $action = $request->get('action');
        $method = $action . 'Action';
        if (method_exists($this, $method)) {
            return $this->$method($request);
        } else {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }
    }

    public function activityReassignAction(Request $request)
    {
        $params = $request->request->all();
       // print_r($params);return;
        if (!empty($params['activities']) && (!empty($params['assignee']))) {
            $activities = $params['activities'];
            /** @var $em EntityManager */
            $em = $this->getDoctrine()->getManager();

            /** @var $assignee User */
            $assignee = $em->getRepository('ZesharCRMCoreBundle:User')->find($params['assignee']);


            /** @var $activityRepository ActivityRepository */
            $activityRepository = $em->getRepository('ZesharCRMCoreBundle:Activity');


            foreach ($activities as $activityId) {
                /** @var $activity Activity */
                $activity = $activityRepository->findOneBy(array('id' => $activityId));
                if ($assignee) {
                    $activity->setAssignee($assignee);
                }
                $em->persist($activity);

                $leads = $activity->getLead();
                if (!empty($leads) && (is_array($leads) || is_object($leads))) {
                    foreach ($leads as $lead) {
                        $lead->setAssignee($assignee);
                        $em->persist($lead);
                    }
                }
            }

            $em->flush();


        }
        return new Response();
    }


    public function activitiesDeleteAction(Request $request)
    {
        $params = $request->request->all();
        // print_r($params);return;
        if (!empty($params['activities'])) {
            $activities = $params['activities'];
            /** @var $em EntityManager */
            $em = $this->getDoctrine()->getManager();

            /** @var $activityRepository ActivityRepository */
            $activityRepository = $em->getRepository('ZesharCRMCoreBundle:Activity');

            foreach ($activities as $activityId) {
                /** @var $activity Activity */
                $activity = $activityRepository->findOneBy(array('id' => $activityId));
                if ($activity) {
                    $leads = $activity->getLead();
                    if(!empty($leads) && (is_array($leads) || is_object($leads))){
                        foreach($leads as $lead){
                            $lead->setLeadCampaign(null);
                            $em->persist($lead);
                        }
                    }
                    $em->remove($activity);
                }
            }

            $em->flush();
        }
        return new Response();
    }
}