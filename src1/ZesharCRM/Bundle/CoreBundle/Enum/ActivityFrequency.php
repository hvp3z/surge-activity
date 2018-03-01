<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class ActivityFrequency {


    const DAILY = 1;
    const WEEKLY = 2;
    const MONTHLY = 3;
    const YEAR = 4;

    public static function getHumanTitlesMap() {

        return array(
            self::DAILY => 'Daily',
            self::WEEKLY => 'Weekly',
            self::MONTHLY => 'Monthly',
            self::YEAR => 'Yearly',
        );
    }

}
