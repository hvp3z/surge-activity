<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class ConversionType {

    const QUOTES_CONVERSION_RATE = 1;
    const OPPORTUNITY_CONVERSION_RATE = 2;
    const WARM_LEADS_CONVERSION_RATE = 3;
    const COLD_LEADS_CONVERSION_RATE = 4;

    public static function getHumanTitlesMap() {
        return array(
          self::QUOTES_CONVERSION_RATE => 'Quotes Conversion  rate',
          self::OPPORTUNITY_CONVERSION_RATE => 'Opportunity Conversion  rate',
          self::WARM_LEADS_CONVERSION_RATE => 'Warm Leads Conversion  rate',
          self::COLD_LEADS_CONVERSION_RATE => 'Cold Leads Conversion  rate',
        );
    }

}
