<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class ActivityStatus {


    const OPEN = 1;
    const CLOSED = 2;

    public static function getHumanTitlesMap() {

        return array(
            self::OPEN => 'Open',
            self::CLOSED => 'Closed',
        );
    }

}
