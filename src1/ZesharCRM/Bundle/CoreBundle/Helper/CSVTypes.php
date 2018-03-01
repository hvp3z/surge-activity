<?php

namespace ZesharCRM\Bundle\CoreBundle\Helper;

class CSVTypes
{
    
    const LEAD = 1;

    public static function getTypes()
    {
        return array(
                self::LEAD => 'Lead',
        );
    }

    public static function getTypesAndIds()
    {
        $all = self::getTypes();
        $return = array();
        foreach($all as $key => $value) {
            $return[] = array('id' => $key, 'title' => $value);
        }
        return $return;
    }

    public static function getNameOfType($type)
    {
        $allTypes = self::getTypes();
        if (isset($allTypes[$type])) return $allTypes[$type];
        return '- Unknown Type -';
    }

    public static function getEntityClass($type)
    {
        switch ($type) {
            case self::LEAD: return 'ZesharCRMCoreBundle:Lead';
            default: return false;
        }
    }

    public static function existsType($type)
    {
        $allTypes = self::getTypes();
        return isset($allTypes[$type]);
    }

}
