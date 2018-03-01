<?php

namespace ZesharCRM\Bundle\CallsBundle\Enum;

abstract class CallReportingStatus {

    const BUSY = 1;
    const COMPLETED = 2;
    const NO_ANSWER = 3;
    const FAILED = 4;
    const CANCELED = 5;
    const CONTACTED = 6;
    const LEFT_MESS = 7;
    const SENT_EMAIL = 8;
    const SENT_MAIL = 9;
    const NEGLECTED = 10;

    public static function getHumanTitlesMap() {

        return array(
            self::BUSY => 'Do Not Call Busy',
            self::COMPLETED => 'Completed',
            self::NO_ANSWER => 'No Answer',
            self::FAILED => 'Failed',
            self::CANCELED => 'Cancelled',
            self::CONTACTED => 'Contacted',
            self::LEFT_MESS => 'Left a message',
            self::SENT_EMAIL => 'Sent email',
            self::SENT_MAIL => 'Sent mail',
            self::NEGLECTED => 'Neglected',
        );
    }

    public static function getNumericalMap() {

        return array_flip(self::getHumanTitlesMap());
    }

}
