<?php

namespace ZesharCRM\Bundle\GoalsBundle\Service\Widget;

use ZesharCRM\Bundle\CoreBundle\Enum\GoalStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\OperationType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ZesharCRM\Bundle\GoalsBundle\Service\Widget\WidgetCalculator;

class CommonWidget
{
    protected static function isAdmin($user)
    {
        $isAdmin = false;
        $roles = $user->getRoles();

        if(in_array('ROLE_SUPER_ADMIN', $roles)){
            $isAdmin = true;
        }

        return $isAdmin;
    }
}