<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class DriverTicketType {

    const SPEEDING  = 1;
    const SEAT_BELT = 2;
    const NO_INSURANCE = 3;
    const ACCIDENT = 4;
    const DUI = 5;
    const DWL = 6;
    const OTHER = 7;

    public static function getHumanTitles() {

        return array(
            self::SPEEDING => 'Speeding',
            self::SEAT_BELT => 'Seat Belt',
            self::NO_INSURANCE => 'No Insurance',
            self::ACCIDENT => 'Accident',
            self::DUI => 'DUI',
            self::DWL => 'DWL',
            self::OTHER => 'Other',
        );
    }

    public static function getEmptyDriverTicketTypeArray($type = 0) {
        return array_combine(array_keys(self::getHumanTitles()), array_fill(0,count(self::getHumanTitles()), $type));
    }

}
