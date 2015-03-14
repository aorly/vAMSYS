<?php namespace vAMSYS\Services\PirepParser\smartCARS;

use vAMSYS\Pirep;
use vAMSYS\Services\PirepParser\Parser;

class Touchdown implements Parser {

    public static function parse($timestamp, $line, $matches, Pirep $pirep)
    {
        $pirep->landing_time = $timestamp;
        $pirep->pirep_data = array_merge($pirep->pirep_data, ['touchdown' =>
            ["gear" => $matches[2],
                "pitch" => $matches[3],
                "roll" => $matches[4],
                "speed" => $matches[5]]]);
        return $pirep;
    }
}
