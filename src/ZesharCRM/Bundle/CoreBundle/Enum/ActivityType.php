<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class ActivityType {
  
  const CALL = 1;
  const SEND_EMAIL = 2;
  const MEETING = 3;

    public static function getHumanTitlesMap() {
        return array(
            self::CALL => 'Call',
            self::SEND_EMAIL => 'Send email',
            self::MEETING => 'Meeting',
        );
    }
  
}
