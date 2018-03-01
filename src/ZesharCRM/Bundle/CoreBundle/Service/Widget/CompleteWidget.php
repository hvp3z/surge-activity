<?php

namespace ZesharCRM\Bundle\CoreBundle\Service\Widget;

use Symfony\Component\DependencyInjection\ContainerInterface;
use ZesharCRM\Bundle\CoreBundle\Enum\OperationType;
class CompleteWidget
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function render($user,$persons)
    {
        $humanTitles = OperationType::getHumanTitlesMap();
        $performance =  array(
            OperationType::LEAD_TO_OPPORTUNITY => array(),
            OperationType::OPPORTUNITY_TO_QUOTE => array()
        );
        $em = $this->container->get('doctrine.orm.entity_manager');
        $operations = $em->getRepository('ZesharCRMCoreBundle:Operation')->getOperationData($user);

        //$operations = $em->getRepository('ZesharCRMCoreBundle:Operation')->findAll();
        //$performance = OperationType::getEmptyOperationArray(array());
        foreach ($operations as $operation) {
            $category = '';
            $type = $operation->getOperationType();
            
            if ($operation->getOperationType() <= 3) { //fix this hard code
                $entity = $operation->getEntity();
                $category = $entity->getLeadCategory()->getTitle();
            } else {
                $entity = $operation->getEntity();
                if ($entity) {
                    if (method_exists($entity, 'getOpportunityCategory')) {
                        if ($entity->getOpportunityCategory()) {
                            $category = $entity->getOpportunityCategory()->getTitle();
                        }
                    }
                }

            }

            if (array_key_exists($type,$performance)){
                if (!array_key_exists($category,$performance[$type])) {
                    $performance[$type][$category] = 1;
                } else {
                    $performance[$type][$category]++;
                }
            }
        }


        return $this->container->get('templating')->render('ZesharCRMCoreBundle:Widget:complete.html.twig', array('data' => $performance,'humanTitles' => $humanTitles, 'persons' => $persons, 'selectedUser' => $user->getUsername()));
    }

}
