<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class DNCStatus {

  const DNC= 1;
  const DNE = 2;
  const DNM = 3;
  const IDNC = 4;
  
  public static function getHumanTitlesMap() {
      return array(
          self::DNC => 'DNC',
          self::DNE => 'DNE',
          self::DNM => 'DNM',
          self::IDNC => 'IDNC',
      );
  }
  
}
