<?php

namespace ZesharCRM\Bundle\CallsBundle\Enum;

abstract class CallReportingType {

    const INBOUND = 1;
    const OUTBOUND = 2;

    public static function getHumanTitlesMap() {

        return array(
            self::INBOUND => 'Inbound',
            self::OUTBOUND => 'Outbound',
        );
    }

}
