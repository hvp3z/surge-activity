<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class ContactCardNetworkType{
    const BUSINESS_CONTACT = 1;
    const SOCIAL_MEDIA = 2;
    const FRIENDS = 3;
    const RELATIVE = 4;
    const ASSOCIATES = 5;

    public static function getHumanTitlesMap() {
        return array(
            self::BUSINESS_CONTACT => 'Business Contact',
            self::SOCIAL_MEDIA => 'Social Media',
            self::FRIENDS => 'Friends',
            self::RELATIVE => 'Relative',
            self::ASSOCIATES => 'Associates',
        );
    }
}