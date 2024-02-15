<?php


namespace App\Library;

use DateTime;

class Date
{

    public static function getCurrent()
    {
        return date('Y-m-d H:i:s');
    }

    public static function getDateTime()
    {
        return new DateTime();
    }

    public static function frontDate($date)
    {
        return date('Y-m-d', strtotime($date));
    }

    public static function responseDate($date)
    {
        return date('d-m-Y H:i:s', strtotime($date));
    }

    public static function getFrontDate($date)
    {
        return date('d.m.Y h:i A', strtotime($date));
    }

    public static function offerDate($date)
    {
        return date('d.m', strtotime($date));
    }

    public static function pickerDate($date)
    {
        return date('d-M-Y', strtotime($date));
    }

    public static function pickerTime($date)
    {
        return date('H:i', strtotime($date));
    }

    public static function backDate($date)
    {
        $date = \DateTime::createFromFormat('d-M-Y', $date);
        return $date->format('Y-m-d');
    }

    public static function backTime($time)
    {
        $date = \DateTime::createFromFormat('H:i', $time);
        return $date->format('H:i:s');
    }

    public static function forumDateTime($timestamp)
    {
        return date('F d', strtotime($timestamp)) . ' at ' . date('h:ia', strtotime($timestamp));
    }
}
