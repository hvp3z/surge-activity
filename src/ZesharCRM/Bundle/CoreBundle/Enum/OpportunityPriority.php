<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class OpportunityPriority {

    const LOW = 1;
    const MEDIUM = 2;
    const HIGH = 3;

    public static function getHumanTitles() {

        return array(
            self::LOW => 'Low',
            self::MEDIUM=> 'Medium',
            self::HIGH => 'High',
        );
    }

    public static function getEmptyPriorityArray($type = 0) {
        return array_combine(array_keys(self::getHumanTitles()), array_fill(0,count(self::getHumanTitles()), $type));
    }
}
