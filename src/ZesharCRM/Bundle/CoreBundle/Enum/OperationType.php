<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class OperationType {

    const COLD_TO_WARM_LEAD = 1;
    const CANCELLED_LEAD = 2;
    const LEAD_TO_OPPORTUNITY = 3;
    const CANCELLED_OPPORTUNITY = 4;
    const OPPORTUNITY_TO_QUOTE = 5;
    const CANCELLED_QUOTE = 6;
    const SUCCESS_QUOTE = 7;
    const WIN_BACK_QUOTE = 8;
    const COLD_LEAD = 9;
    const NEW_LEAD = 10;
    const OPPORTUNITY_TO_LEAD = 11;
    const HOT_LEAD = 12;
    const COLD_BECAME_ACTIVE = 13;

    public static function getHumanTitlesMap() {
        return array(
            self::COLD_TO_WARM_LEAD => 'Cold to Warm lead',
            self::CANCELLED_LEAD => 'UnSold lead',
            self::LEAD_TO_OPPORTUNITY => 'Lead to opportunity',
            self::CANCELLED_OPPORTUNITY => 'UnSold opportunity',
            self::OPPORTUNITY_TO_QUOTE => 'Opportunity to quote',
            self::CANCELLED_QUOTE => 'UnSold quote',
            self::SUCCESS_QUOTE => 'Sold quote',
            self::WIN_BACK_QUOTE => 'Win-back quote',
            self::COLD_LEAD => 'Cold Lead',
            self::NEW_LEAD => 'New Lead',
            self::OPPORTUNITY_TO_LEAD => 'Opportunity to lead',
            self::HOT_LEAD => 'Hot Lead',
            self::COLD_BECAME_ACTIVE => 'Cold became active'
        );
    }

    public static function getEmptyOperationArray($type = 0) {
        return array_combine(array_keys(self::getHumanTitlesMap()), array_fill(0,count(self::getHumanTitlesMap()), $type));
    }
}
