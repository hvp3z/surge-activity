<?php

namespace ZesharCRM\Bundle\LeadScoringBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sonata\AdminBundle\Controller\CoreController;
use Doctrine\ORM\EntityRepository;
use ZesharCRM\Bundle\CoreBundle\Entity\Lead;
use ZesharCRM\Bundle\CoreBundle\Entity\Opportunity;
use ZesharCRM\Bundle\LeadScoringBundle\Entity\LeadScoring;

class ScoringAdminController extends CoreController
{
    private $data = array();

    private $total =array();

    private $checkCriteriaId = array();

    public function scoringAction(Request $request)
    {
        $em = $this->getDoctrine();

        if($leadId = $request->get('lead')){
            $entity = $em->getRepository('ZesharCRMCoreBundle:Lead')->findOneById($leadId);
            $parameter = array('lead'=>$entity);
        } else if($opportunityId = $request->get('opportunity')){
            $entity = $em->getRepository('ZesharCRMCoreBundle:Opportunity')->findOneById($opportunityId);
            $parameter = array('opportunity'=>$entity);
        } else {
            $this->get('session')->getFlashBag()->add('error','Must be passed parameters lead or opportunity!');
            $url = $request->headers->get("referer");
            return new RedirectResponse($url);
        }

        $leadScoring = $em->getRepository('ZesharCRMLeadScoringBundle:LeadScoring')->findOneBy($parameter);

        $criteria = $em->getRepository('ZesharCRMLeadScoringBundle:ScoringCriteria')->findAll();

        $checkCriteria = array();

        if ($leadScoring) {
            $this->checkCriteriaId = unserialize($leadScoring->getScoring());
            foreach ($criteria as $value) {
                if (in_array($value->getId(), $this->checkCriteriaId)) {
                    array_push($checkCriteria,$value);
                }
            }
        } else {
            $leadScoring = new LeadScoring();
        }

        $firstCriteria = $em->getRepository('ZesharCRMLeadScoringBundle:ScoringCriteria')->findBy(array('parent' => null));

        $this->showTree(null,$criteria);

        $this->showTotal($firstCriteria);


        $formBuilder = $this->createFormBuilder();

        $formBuilder->add('criteria', 'entity', array(
            'expanded' => true,
            'multiple' => true,
            'mapped' => false,
            'class' => 'ZesharCRMLeadScoringBundle:ScoringCriteria',
            'choices' => $this->total,
        ));

        $formBuilder->add('save', 'submit');

        $form = $formBuilder->getForm();

        $form->get('criteria')->setData($checkCriteria);

        if ($request->getMethod() == 'POST') {

            $scoring = array();

            $form->handleRequest($request);

            $data = $form->get('criteria')->getData();

            foreach($data as $value ){
                array_push($scoring,$value->getId());
            }

            if ($form->isValid()) {

                if ($entity instanceof Lead) {
                    $leadScoring->setLead($entity);
                    if ($entity->getOpportunity()) {
                        $leadScoring->setOpportunity($entity->getOpportunity());
                    }
                } else if ($entity instanceof Opportunity) {
                    $leadScoring->setOpportunity($entity);
                    if ($entity->getLead()) {
                        $leadScoring->setLead($entity->getLead());
                    }
                }

                $leadScoring->setScoring(serialize($scoring));
                $leadScoring->setTotal(0);
                foreach(array_intersect($checkCriteria,$this->total) as $value){
                    $leadScoring->setTotal($leadScoring->getTotal()+$value->getScore());
                }

                $em->getManager()->persist($leadScoring);
                $em->getManager()->flush($leadScoring);

            }
        }

        return $this->render('ZesharCRMLeadScoringBundle:ScoringCRUD:scoring.html.twig', array(
            'base_template'   => $this->getBaseTemplate(),
            'admin_pool'      => $this->container->get('sonata.admin.pool'),
            'blocks'          => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks'),
            'entity'          => $entity,
            'leadScoring'     => $leadScoring,
            'form' => $form->createView(),
            'firstCriteria' => $firstCriteria
        ));
    }

    private function showTree($ParentID, $entities)
    {
        if ($entities) {
            foreach($entities as $entity){
                $entityParentId = $entity->getParent() ? $entity->getParent()->getId() : null;
                if ($entityParentId == $ParentID){
                    $this->data[] = $entity;
                    $this->showTree($entity->getId(), $entities);
                }
            }
        }
    }

    private function showTotal($entities, $percent = null)
    {
            foreach($entities as $entity){
                if ($percent) {
                    $currentPercent = $percent*$entity->getScore()/100;
                } else {
                    $currentPercent = $entity->getScore();
                }
                if (count($entity->getChildren()) > 0){
                    $this->showTotal($entity->getChildren(),$currentPercent);
                } else {
                    $entity->setScore($currentPercent);
                    $this->total[] = $entity;
                }
            }
    }
}
