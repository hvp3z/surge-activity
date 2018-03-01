<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class LogType {

  const LOGIN = 1;
  const LOGOUT = 2;

  
  public static function getHumanTitlesMap() {
      return array(
          self::LOGIN => 'Login',
          self::LOGOUT => 'Logout',
      );
  }

  public static function getEmptyLogArray($type = 0) {
      return array_combine(array_keys(self::getHumanTitlesMap()), array_fill(0,count(self::getHumanTitlesMap()), $type));
  }
}
