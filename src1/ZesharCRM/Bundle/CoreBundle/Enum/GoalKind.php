<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class GoalKind {

    const COLD_TO_WARM_LEAD  = 1;
    const LEAD_TO_OPPORTUNITY = 2;
    const OPPORTUNITY_TO_QUOTE = 3;
    const SUCCESS_QUOTE = 4;

    public static function getHumanTitles() {

        return array(
            self::COLD_TO_WARM_LEAD => 'Cold to Warm',
            self::LEAD_TO_OPPORTUNITY => 'Lead to Opportunity',
            self::OPPORTUNITY_TO_QUOTE => 'Opportunity to Quote',
            self::SUCCESS_QUOTE => 'Quote to Close'
        );
    }

    public static function getEmptyGoalKindArray($type = 0) {
        return array_combine(array_keys(self::getHumanTitles()), array_fill(0,count(self::getHumanTitles()), $type));
    }

}
