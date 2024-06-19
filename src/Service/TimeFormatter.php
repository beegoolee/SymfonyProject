<?php

namespace App\Service;

class TimeFormatter
{
    public function getFormattedTime(string $timestamp, string $format = "d M, H:i"): ?string
    {
        date_default_timezone_set('Etc/GMT-3');
        return date($format, $timestamp);
    }
}