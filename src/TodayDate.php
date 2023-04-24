<?php

namespace App;

use DateTime;

class TodayDate
{
    public static string $date;
    public static function getToday(): DateTime
    {
        $dateToday = new DateTime();
        return $dateToday;
    }

    private function __construct()
    {
    }

    public static function getDate(): string
    {
        $date = self::getToday()->format('d.m.Y');
        return $date;
    }
}
