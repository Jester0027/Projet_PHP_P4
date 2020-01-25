<?php

namespace BlogApp\src\helpers;

use DateTime;
use DateTimeZone;

class Date
{
    const MONTHS_FR = [
        '01' => 'Janvier',
        '02' => 'Février',
        '03' => 'Mars',
        '04' => 'Avril',
        '05' => 'Mai',
        '06' => 'Juin',
        '07' => 'Juillet',
        '08' => 'Août',
        '09' => 'Septembre',
        '10' => 'Octobre',
        '11' => 'Novembre',
        '12' => 'Décembre'
    ];

    private static function getMonthFR(string $monthNumber)
    {
        foreach(self::MONTHS_FR as $key => $value) {
            if($monthNumber === $key) return $value;
        }
        return $monthNumber;
    }

    private static function getDayFR(string $dayNumber)
    {
        if($dayNumber[0] === '0') {
            if($dayNumber[1] === '1') return '1er';
            return $dayNumber[1];
        }
        return $dayNumber;
    }

    public function getCurrentDate()
    {
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('Europe/Paris'));
        return $date->format('Y-m-d H:i:s');
    }

    public static function formatDateFR(string $date)
    {
        $date = new DateTime($date);
        $formatedDate = $date->format('d/m/Y');
        $day = substr($formatedDate, 0, 2);
        $day = self::getDayFR($day);
        $month = trim(substr($formatedDate, 2, 4), '/');
        $month = self::getMonthFR($month);
        $formatedDate = substr_replace($formatedDate, " $month ", 2, 4);
        $formatedDate = substr_replace($formatedDate, "$day", 0, 2);
        return $formatedDate;
    }

    public static function formatDateTimeFR(string $date)
    {
        $date = new DateTime($date);
        return $date->format('d/m/Y H:i:s');
    }
}