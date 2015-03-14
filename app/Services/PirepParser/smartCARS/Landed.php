<?php namespace vAMSYS\Services\PirepParser\smartCARS;

use vAMSYS\Pirep;
use vAMSYS\Services\PirepParser\Parser;

class Landed implements Parser {

    public static function parse($timestamp, $line, $matches, Pirep $pirep)
    {
        $pirep->pirep_data = array_merge($pirep->pirep_data, ['landing' =>
            ["length" => $matches[1],
            "fuel" => $matches[2],
            "weight" => $matches[3]]]);
        return $pirep;
    }
}
