<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class ProductType {


    const BASIC = 0;
    const ADVANCED = 1;

    public static function getHumanTitlesMap() {

        return array(
            self::BASIC => 'Basic',
            self::ADVANCED => 'Advanced',
        );
    }

}
