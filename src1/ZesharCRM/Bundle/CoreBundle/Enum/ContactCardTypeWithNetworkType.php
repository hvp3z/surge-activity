<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

use ZesharCRM\Bundle\CoreBundle\Enum\ContactCardType;

abstract class ContactCardTypeWithNetworkType{
    const LEAD = ContactCardType::LEAD;
    const RNS = ContactCardType::RNS;
    const LEAD_CUSTOMER = ContactCardType::LEAD_CUSTOMER;
    const LEAD_EX_CUSTOMER = ContactCardType::LEAD_EX_CUSTOMER;
    const RNS_BUSINESS_CONTACT = 101;
    const RNS_SOCIAL_MEDIA = 102;
    const RNS_FRIENDS = 103;
    const RNS_RELATIVE = 104;
    const RNS_ASSOCIATES = 105;

    public static function getHumanTitlesMap() {
        return array(
            self::LEAD => 'Lead',
            self::LEAD_CUSTOMER => 'Lead/Customer',
            self::LEAD_EX_CUSTOMER => 'Lead/Ex-Customer',
            self::RNS => 'Network',
            self::RNS_BUSINESS_CONTACT => 'Network/Business Contact',
            self::RNS_SOCIAL_MEDIA => 'Network/Social Media',
            self::RNS_FRIENDS => 'Network/Friends',
            self::RNS_RELATIVE => 'Network/Relative',
            self::RNS_ASSOCIATES => 'Network/Associates',
        );
    }
}