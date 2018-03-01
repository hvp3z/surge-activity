<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class ContactCardType {

    const LEAD = 1;
    const RNS = 2;
    const LEAD_CUSTOMER = 3;
    const LEAD_EX_CUSTOMER = 4;

    public static function getHumanTitlesMap() {
        return array(
            self::LEAD => 'Lead',
            self::RNS => 'Network',
            self::LEAD_CUSTOMER => 'Lead/Customer',
            self::LEAD_EX_CUSTOMER => 'Lead/Ex-Customer',
        );
    }

}