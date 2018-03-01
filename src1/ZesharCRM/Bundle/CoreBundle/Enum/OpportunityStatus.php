<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class OpportunityStatus {

    const PENDING_OPPORTUNITY = 1;
    const CANCELLED_OPPORTUNITY = 2;
    const PENDING_QUOTE = 3;
    const CANCELLED_QUOTE = 4;
    const SUCCESS_QUOTE = 5;
    const WIN_BACK = 6;

    public static function getHumanTitlesMap() {

        return array(
            self::PENDING_OPPORTUNITY => 'Pending opportunity',
            self::CANCELLED_OPPORTUNITY => 'UnSold opportunity',
            self::PENDING_QUOTE => 'Pending quote',
            self::CANCELLED_QUOTE => 'UnSold quote',
            self::SUCCESS_QUOTE => 'Sold quote',
            self::WIN_BACK => 'Win-Back quote'
        );
    }
}
