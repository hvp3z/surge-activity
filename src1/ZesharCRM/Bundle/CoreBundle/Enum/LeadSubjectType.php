<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class LeadSubjectType {

    const RECYCLED = 1;
    const WINBACK = 2;
    const CROSS_SELL = 3;

    public static function getHumanTitlesMap() {
        return array(
            self::RECYCLED => 'Recycled',
            self::WINBACK => 'Winback',
            self::CROSS_SELL => 'Cross Sell',
        );
    }

}
