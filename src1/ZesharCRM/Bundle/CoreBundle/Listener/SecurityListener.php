<?php

namespace ZesharCRM\Bundle\CoreBundle\Listener;

use Symfony\Component\Security\Core\SecurityContextInterface;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use ZesharCRM\Bundle\CoreBundle\Entity\Log;
use ZesharCRM\Bundle\CoreBundle\Enum\LogType;

class SecurityListener
{
    public function __construct(SecurityContextInterface $security, $container)
    {
        $this->security = $security;
        $this->container = $container;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $this->security->getToken()->getUser();
        $em = $this->container->get('doctrine.orm.entity_manager');
        $logAction = new Log();
        $logAction
          ->setPerformer($user)
          ->setOperationType(LogType::LOGIN);

        $em->persist($logAction);
        $em->flush();

    }

}
 