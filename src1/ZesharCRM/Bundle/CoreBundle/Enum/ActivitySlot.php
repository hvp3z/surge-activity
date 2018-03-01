<?php

namespace ZesharCRM\Bundle\CoreBundle\Enum;

abstract class ActivitySlot {


    const DAILY = 1;
    const WEEKLY = 2;
    const MONTHLY = 3;
    const YEAR = 4;

    public static function getHumanTitlesMap($frequency = null)
    {
        switch($frequency){
            case '1':
                return self::getTime();
            case '2':
                return self::getDays();
            case '3':
                return self::getDates();
            case '4':
                return self::getMonths();
            default:
                return self::getDays();
        }
    }

    private static function getMonths()
    {
        $months = array();
        for($i = 1; $i < 13; $i++){
            $timestamp = mktime(0, 0, 0, date(12) + $i, 1);
            $months[] = date('F', $timestamp);
        }

        return $months;
    }

    private static function getDays(){
        $timestamp = strtotime('next Sunday');
        $days = array();
        for($i = 0; $i < 7; $i++){
            $days[] = strftime('%A', $timestamp);
            $timestamp = strtotime('+1 day', $timestamp);
        }

        return $days;
    }

    private static function getDates()
    {
        $dates = array();
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        for($i = 1; $i < 32; $i++){
            if ((($i % 100) >= 11) && (($i%100) <= 13))
                $dates[] = $i. 'th';
            else
                $dates[] = $i. $ends[$i % 10];
        }

        return $dates;
    }

    private static function getTime()
    {
        $time = array();
        for($i=1; $i<24; $i++){
            $time[] = $i . ':00';
        }

        return $time;
    }

}
