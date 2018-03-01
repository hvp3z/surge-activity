<?php

namespace ZesharCRM\Bundle\CoreBundle\Service\Widget;

use Symfony\Component\DependencyInjection\ContainerInterface;
use ZesharCRM\Bundle\CoreBundle\Enum\OpportunityStatus;

class AssignedOpportunityWidget
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function render($user,$persons)
    {
        $entities = $this->container->get('doctrine.orm.entity_manager')->getRepository('ZesharCRMCoreBundle:Opportunity')->findBy(array('status' => OpportunityStatus::PENDING_OPPORTUNITY, 'assignee' => $user));
        return $this->container->get('templating')->render('ZesharCRMCoreBundle:Widget:assignedOpportunity.html.twig', array(
            'data' => $entities,
            'persons' => $persons,
            'selectedUser' => $user->getUsername(),
            'opportunityStatus' => OpportunityStatus::getHumanTitlesMap()
        ));
    }

}
