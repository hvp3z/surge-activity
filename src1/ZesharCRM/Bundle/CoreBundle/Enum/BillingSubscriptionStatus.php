<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class BillingSubscriptionStatus {

    const INACTIVE = 0;
    const ACTIVE = 1;

    public static function getHumanTitlesMap() {

        return array(
            self::INACTIVE => 'Inactive',
            self::ACTIVE => 'Active',
        );
    }
}
