<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class InsuredAddressType {

    const OWN = 1;
    const RENT = 2;

    public static function getHumanTitlesMap() {
        return array(
            self::OWN => 'OWN',
            self::RENT => 'RENT',
        );
    }

    public static function getEmptyInsuredAddressTypeArray($type = 0) {
        return array_combine(array_keys(self::getHumanTitlesMap()), array_fill(0,count(self::getHumanTitlesMap()), $type));
    }

}