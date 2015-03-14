<?php namespace vAMSYS\Services\PirepParser\smartCARS;

use vAMSYS\Pirep;
use vAMSYS\Services\PirepParser\Parser;

class Takeoff implements Parser {

    public static function parse($timestamp, $line, $matches, Pirep $pirep)
    {
        $pirep->departure_time = $timestamp;
        return $pirep;
    }
}
