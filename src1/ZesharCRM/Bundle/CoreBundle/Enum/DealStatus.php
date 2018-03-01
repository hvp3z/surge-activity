<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class DealStatus {
  
  const PENDING = 1;
  const SUCCESS = 2;
  const CANCELLED = 3;
  const WIN_BACK = 4;

  public static function getHumanTitlesMap() {
      return array(
          self::PENDING => 'Pending',
          self::SUCCESS => 'Sold',
          self::CANCELLED => 'UnSold',
          self::WIN_BACK => 'Win-Back',
      );
  }
  
}
