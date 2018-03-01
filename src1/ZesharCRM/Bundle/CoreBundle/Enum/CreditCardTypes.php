<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class CreditCardTypes {

    const VISA = 0;
    const DISCOVER = 1;
    const MASTER = 2;
    const AMERICAN = 3;

    public static function getHumanTitlesMap() {

        return array(
            self::VISA => 'Visa',
            self::DISCOVER => 'Discover Network',
            self::MASTER => 'MasterCard',
            self::AMERICAN => 'American Express',
        );
    }
}
