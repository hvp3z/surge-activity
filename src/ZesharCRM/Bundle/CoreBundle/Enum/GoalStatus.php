<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class GoalStatus {


    const OPEN = 1;
    const FAIL_CLOSED = 2;
    const SUCCESS_CLOSED = 3;

    public static function getHumanTitles() {

        return array(
            self::OPEN => 'Open',
            self::FAIL_CLOSED => 'Fail closed',
            self::SUCCESS_CLOSED => 'Success closed'
        );
    }

}
