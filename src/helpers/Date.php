<?php

namespace BlogApp\src\helpers;

use DateTime;
use DateTimeZone;

class Date
{
    public function getCurrentDate()
    {
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('Europe/Paris'));
        return $date->format('Y-m-d H:i:s');
    }

    public static function formatDateFR(string $date)
    {
        $date = new DateTime($date);
        return $date->format('d/m/Y');
    }

    public static function formatDateTimeFR(string $date)
    {
        $date = new DateTime($date);
        return $date->format('d/m/Y H:i:s');
    }
}