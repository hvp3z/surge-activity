<?php

namespace ZesharCRM\Bundle\CoreBundle\Service\Widget;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ZesharCRM\Bundle\CoreBundle\Entity\LeadCategory;
use ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject;
use ZesharCRM\Bundle\CoreBundle\Enum\OperationType;
use ZesharCRM\Bundle\CoreBundle\Repository\OperationRepository;
use ZesharCRM\Bundle\CoreBundle\Repository\LeadSubjectRepository;
use Doctrine\ORM\EntityRepository;
use ZesharCRM\Bundle\CoreBundle\Repository\WidgetRepository;

class TargetWidget
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function render($user,$persons)
    {
        /** @var $em EntityManager */
        $em = $this->container->get('doctrine.orm.entity_manager');

        /** @var $operationRepository OperationRepository */
        $operationRepository = $em->getRepository('ZesharCRMCoreBundle:Operation');

        /** @var $leadSubjectRepository LeadSubjectRepository */
        $leadSubjectRepository =  $em->getRepository('ZesharCRMCoreBundle:LeadSubject');
        $soldItems = $leadSubjectRepository->getSoldItemsByProducts();

        $data = $operationRepository->getProductsForWidget($user);

        foreach ($data as $key => $product) {
            foreach ($soldItems as $soldItem) {
                if ($product['id'] == $soldItem['product']) {
                    $data[$key]['soldItems'] = $soldItem['soldItems'];
                    $data[$key]['value'] = $soldItem['quotedAmount'];
                }
            }
        }
        $goals = $operationRepository->getGoalsForWidget($user);
        $newGoalsArr = array();

        if(!empty($goals)){
            foreach($goals as $key=>$goal){
                $newGoalsArr[$key] = $goal['title'];
            }
        }

        if(!empty($data)){
            foreach($data as $d){
                if(in_array($d['title'], $newGoalsArr)){
                    $key = array_search($d['title'], $newGoalsArr);
                    unset($newGoalsArr[$key]);
                }
            }
        }

        $isAll = WidgetRepository::isShowAllData($user);

        if(!empty($newGoalsArr)){
            foreach($newGoalsArr as $goal){
                $qb = $this->container->get('doctrine.orm.entity_manager')
                    ->createQueryBuilder()
                    ->select('goal.id as id')
                    ->from('ZesharCRMGoalsBundle:Goal', 'goal')
                    ->leftJoin('goal.goalCategory', 'leadCategory')
                    ->where('leadCategory.title = :goal')
                    ->leftJoin('goal.assignments', 'ass')
                    ->setParameters(array('goal' => $goal))
                    ->groupBy('leadCategory.id')
                ;
                if(!$isAll){
                    $qb
                        ->andWhere('ass.assignee ='.$user->getId())
                    ;
                }
                $goalObj = $qb->getQuery()->getSingleResult();
                $goalId = $goalObj['id'];

                if(!$isAll){
                    $findArr = array('goal' => $goalId, 'user' => $user->getId());
                }else{
                    $findArr = array('goal' => $goalId);
                }
                $goalAssign = $em->getRepository('ZesharCRMGoalsBundle:GoalAssign')->findOneBy($findArr);

                if ($goalAssign) {
                    $items = round($goalAssign->getItems());
                } else {
                    $items = 0;
                }

                $data[] = array('title' => $goal, 'items' => $items, 'soldItems' => 0, 'value' => '0.00');
            }
        }

        return $this->container->get('templating')->render('ZesharCRMCoreBundle:Widget:target.html.twig', array('data' => $data, 'persons' => $persons, 'selectedUser' => $user->getUsername()));
    }
}