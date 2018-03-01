<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class BillingSubscriptionProducts {

    const SURGE_ACTIVITY = 0;
    const SURGE_ACTIVITY_PRO = 1;

    public static function getHumanTitlesMap() {

        return array(
            self::SURGE_ACTIVITY => 'SurgeActivity',
            self::SURGE_ACTIVITY_PRO => 'SurgeActivity Pro',
        );
    }
}
