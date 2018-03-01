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


class LeadListController extends Controller
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

    public function leadReassignAction(Request $request)
    {
        $params = $request->request->all();
       // print_r($params);return;
        if (!empty($params['leads']) && (!empty($params['assignee']) || !empty($params['campaign']))) {
            /** @var $em EntityManager */
            $em = $this->getDoctrine()->getManager();

            /** @var $leadsRepository LeadRepository */
            $leadsRepository = $em->getRepository('ZesharCRMCoreBundle:LeadSubject');
            /** @var $assignee User */
            $assignee = $em->getRepository('ZesharCRMCoreBundle:User')->find($params['assignee']);

            /** @var $activity Activity */
            $activity = $em->getRepository('ZesharCRMCoreBundle:Activity')->find($params['campaign']);

            foreach ($params['leads'] as $leadId) {
                /** @var $lead LeadSubject */
                $lead = $leadsRepository->findOneBy(array('id' => $leadId));
                if ($assignee) {
                    $lead->setAssignee($assignee);
                }
                if ($activity) {
                    $lead->setLeadCampaign($activity);
                    $assignee = $activity->getAssignee();
                    $lead->setAssignee($assignee);
                }

                $em->persist($lead);
            }
            $em->flush();
        }
        return new Response();
    }

    public function leadDeleteAction(Request $request)
    {
        $params = $request->request->all();

        if (!empty($params['delete_leads'])) {

            /** @var $em EntityManager */
            $em = $this->getDoctrine()->getManager();
            $date = new \DateTime('today');
            $timestamp = $date->getTimestamp();
            $now = date("Y-m-d H:i:s" , $timestamp);

            /** @var $leadSubjectRepository LeadRepository */
            $leadSubjectRepository = $em->getRepository('ZesharCRMCoreBundle:LeadSubject');

            foreach ($params['delete_leads'] as $leadSubjectId) {
                /** @var $leadSubject LeadSubject */
                $leadSubject = $leadSubjectRepository->findOneBy(array('id' => $leadSubjectId));
                if($leadSubject){
                    $leadSubject->setDeletedAt($date);
                    $leadSubject->setIsArchive(true);
                    if($this->get('request')->request->get('permanently') == 'true'){
                        $em->remove($leadSubject);
                    }
                }
            }
            $em->flush();
        }

        return new Response();
    }

    public function leadReestablishAction(Request $request)
    {
        $params = $request->request->all();

        if (!empty($params['reestablish_leads'])) {
            $em = $this->getDoctrine()->getManager();

            /** @var $leadSubjectRepository LeadRepository */
            $leadSubjectRepository = $em->getRepository('ZesharCRMCoreBundle:LeadSubject');

            foreach ($params['reestablish_leads'] as $leadSubjectId) {
                /** @var $leadSubject LeadSubject */
                $leadSubject = $leadSubjectRepository->findOneBy(array('id' => $leadSubjectId));
                $leadSubject->setDeletedAt(null);
                $leadSubject->setIsArchive(false);
            }
            $em->flush();
        }

        return new Response();
    }
}