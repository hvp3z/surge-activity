<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class LeadContactStatus {

  const YES = 1;
  const NO = 2;
  const NEGLECTED = 3;

  public static function getHumanTitlesMap() {
      return array(
          self::YES => 'Yes',
          self::NO => 'No',
          self::NEGLECTED => 'Neglected',
      );
  }
  
}
