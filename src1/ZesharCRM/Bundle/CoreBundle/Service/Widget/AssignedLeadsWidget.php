<?php

namespace ZesharCRM\Bundle\CoreBundle\Service\Widget;

use Symfony\Component\DependencyInjection\ContainerInterface;
use ZesharCRM\Bundle\CoreBundle\Enum\DealStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\LeadType;

class AssignedLeadsWidget
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function render($user,$persons)
    {
        $entities = $this->container->get('doctrine.orm.entity_manager')->getRepository('ZesharCRMCoreBundle:Lead')->findBy(array('status' => DealStatus::PENDING, 'assignee' => $user));
        return $this->container->get('templating')->render('ZesharCRMCoreBundle:Widget:assignedLeads.html.twig', array(
            'data' => $entities,
            'persons' => $persons,
            'selectedUser' => $user->getUsername(),
            'leadType' => LeadType::getHumanTitlesMap(),
            'leadStatus' => DealStatus::getHumanTitlesMap()
        ));
    }

}
