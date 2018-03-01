<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class LeadType {
  
    const COLD = 1;
    const WARM = 2;
    const HOT = 3;
  
    public static function getHumanTitlesMap() {
        return array(
          self::COLD => 'Cold',
          self::WARM => 'Warm',
          self::HOT => 'Hot',
        );
    }
  
}
