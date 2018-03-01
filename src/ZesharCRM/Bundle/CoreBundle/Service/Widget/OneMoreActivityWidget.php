<?php

namespace ZesharCRM\Bundle\CoreBundle\Service\Widget;

use Symfony\Component\DependencyInjection\ContainerInterface;

class OneMoreActivityWidget
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function render($user,$persons)
    {
        $activities = $this->container->get('doctrine.orm.entity_manager')->getRepository('ZesharCRMCoreBundle:Activity')->getWidgetActivities($user);

        return $this->container->get('templating')->render('ZesharCRMCoreBundle:Widget:oneMoreActivity.html.twig', array('activities' => $activities,   'persons' => $persons, 'selectedUser' => $user->getUsername()));
    }

}
