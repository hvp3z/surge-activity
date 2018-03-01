<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class MilestoneOperationType {
    const NEW_LEAD = 1;
    const LEAD_TO_OPPORTUNITY = 2;
    const OPPORTUNITY_TO_LEAD = 3;
    const OPPORTUNITY_TO_QUOTE = 4;
    const QUOTE_TO_OPPORTUNITY = 5;
    const SOLD = 6;

    public static function getHumanTitlesMap() {
        return array(
            self::NEW_LEAD => 'New lead',
            self::LEAD_TO_OPPORTUNITY => 'Lead to opportunity',
            self::OPPORTUNITY_TO_LEAD => 'Opportunity to lead',
            self::OPPORTUNITY_TO_QUOTE => 'Opportunity to quote',
            self::QUOTE_TO_OPPORTUNITY => 'Quote to opportunity',
            self::SOLD => 'Sold',
        );
    }

    public static function getEmptyMilestoneOperationArray($type = 0) {
        return array_combine(array_keys(self::getHumanTitlesMap()), array_fill(0,count(self::getHumanTitlesMap()), $type));
    }
}