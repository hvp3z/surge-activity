<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class ContactType {
  
    const GENERIC_PHONE = 1;
    const CELL_PHONE = 2;
    const WORK_PHONE = 3;
    const EMAIL = 4;
    const SKYPE = 5;
    const TWITTER = 6;
    const CUSTOM = 7;
    const SEMINAR = 8;
    const MEETING = 9;
    const PRESENTATION = 10;
    const CONFERENCE = 11;
    const OTHER = 12;

  
  public static function getHumanTitlesMap() {
      return array(
          self::GENERIC_PHONE => 'Generic Phone',
          self::CELL_PHONE => 'Celluar Phone',
          self::WORK_PHONE => 'Work Phone',
          self::EMAIL => 'E-mail',
          self::SKYPE => 'Skype',
          self::TWITTER => 'Twitter',
          self::CUSTOM => 'Custom'
      );
  }

    public static function getHumanTitlesMapWide() {
        return array_merge(self::getHumanTitlesMap(),array(
            self::SEMINAR => 'Seminar',
            self::MEETING => 'Meeting',
            self::PRESENTATION => 'Presentation',
            self::CONFERENCE => 'Conference',
            self::OTHER => 'Other'
        ));
    }
}