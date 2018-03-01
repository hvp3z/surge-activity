<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class LeadMailStatus {

    const TYPE_YES = 1;
    const TYPE_NO = 0;

    public static function getHumanTitlesMap() {
        return array(
            self::TYPE_YES => 'Yes',
            self::TYPE_NO => 'No',
        );
    }

}
