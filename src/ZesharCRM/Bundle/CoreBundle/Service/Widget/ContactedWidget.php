<?php

namespace ZesharCRM\Bundle\CoreBundle\Service\Widget;

use Symfony\Component\DependencyInjection\ContainerInterface;
use ZesharCRM\Bundle\CoreBundle\Enum\OperationType;
use ZesharCRM\Bundle\CoreBundle\Enum\OpportunityStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\DealStatus;
class ContactedWidget
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function render($user,$persons)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $operations = $em->getRepository('ZesharCRMCoreBundle:Operation')->getOperationData($user);

        $performance = array();
        $leadCategoryCount = array();
        $quote = array();

        foreach ($operations as $item) {

            if ($item->getOperationType() === OperationType::COLD_TO_WARM_LEAD) {
                $entity = $em->getRepository('ZesharCRMCoreBundle:Lead')->findOneById($item->getEntity());
                if ($entity && $entity->getLeadCategory()) {
                    $category = $entity->getLeadCategory()->getTitle();
                    if (!array_key_exists($category,$performance)) {
                        $performance[$category] = 0;
                    }
                    $performance[$category]++;
                }
            } else if ( $item->getOperationType() === OperationType::CANCELLED_LEAD || $item->getOperationType() === OperationType::LEAD_TO_OPPORTUNITY) {
                $entity = $em->getRepository('ZesharCRMCoreBundle:Lead')->findOneById($item->getEntity());
                if ($entity->getLeadCategory()) {
                    $category = $entity->getLeadCategory()->getTitle();
                    if (!array_key_exists($category, $leadCategoryCount)) {
                        $leadCategoryCount[$category] = 0;
                    }
                    $leadCategoryCount[$category]++;
                }
            } else if ( $item->getOperationType() === OperationType::OPPORTUNITY_TO_QUOTE) {
                $entity = $em->getRepository('ZesharCRMCoreBundle:Opportunity')->findOneById($item->getEntity());
                if ($entity && $entity->getLeadCategory()) {
                    $category = $entity->getOpportunityCategory()->getTitle();
                    if (!array_key_exists($category,$quote)) {
                        $quote[$category] = 0;
                    }
                    $quote[$category]++;
                }

            }
        }

        $leads = $em->getRepository('ZesharCRMCoreBundle:Lead')->findBy(array('assignee' => $user,'status' => DealStatus::PENDING));
        foreach ($leads as $lead) {
            $category = $lead->getLeadCategory();
            if($category){
                $categoryTitle = $category->getTitle();
                if (!array_key_exists($categoryTitle, $leadCategoryCount)) {
                    $leadCategoryCount[$categoryTitle] = 0;
                }
                $leadCategoryCount[$categoryTitle]++;
            }

        }
        $contacted = array();
        foreach ($leadCategoryCount as $key=>$value) {
            if(!isset($performance[$key]))
                $performance[$key] = 0;
            if(!isset($quote[$key]))
                $quote[$key] = 0;
            $contacted[$key] = array('percent' => round($performance[$key]/$leadCategoryCount[$key]*100),'quote' => $quote[$key]);
        }
        return $this->container->get('templating')->render('ZesharCRMCoreBundle:Widget:contacted.html.twig', array('data' => $contacted,'persons' => $persons, 'selectedUser' => $user->getUsername()));
    }

}
