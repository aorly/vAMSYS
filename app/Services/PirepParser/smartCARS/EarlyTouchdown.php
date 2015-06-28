<?php namespace vAMSYS\Services\PirepParser\smartCARS;

use vAMSYS\Pirep;
use vAMSYS\Services\PirepParser\Parser;

class EarlyTouchdown implements Parser {

    public static function parse($timestamp, $line, $matches, Pirep $pirep)
    {
        $pirepData = $pirep->pirep_data;
        $earlyTouchdown = ["timestamp" => $timestamp, "rate" => $matches[1], "gear" => $matches[2], "flaps" =>
            $matches[3]];

        if (!array_key_exists('early_touchdowns', $pirepData))
            $pirep->pirep_data = array_merge($pirepData, ['early_touchdowns' => []]);

        $pirepData['early_touchdowns'][] = $earlyTouchdown;

        $pirep->pirep_data = $pirepData;
        $pirep->landing_time = $timestamp;

        return $pirep;
    }
}
