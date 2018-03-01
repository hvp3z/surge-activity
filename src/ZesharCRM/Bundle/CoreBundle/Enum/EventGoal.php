<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class EventGoal {

    const FIRST_CONTACT  = 1;
    const PRESENT = 2;
    const FOLLOW_UP = 3;
    const PRESENT_QUOTE = 4;
    const CLOSE = 5;
    const POST_SALE = 6;

    public static function getHumanTitles() {

        return array(
            self::FIRST_CONTACT => 'First Contact',
            self::PRESENT => 'Present',
            self::FOLLOW_UP => 'Follow Up',
            self::PRESENT_QUOTE => ' Present Quote',
            self::CLOSE => 'Close',
            self::POST_SALE => 'Post Sale',
        );
    }

    public static function getEmptyEventGoalArray($type = 0) {
        return array_combine(array_keys(self::getHumanTitles()), array_fill(0,count(self::getHumanTitles()), $type));
    }

}
