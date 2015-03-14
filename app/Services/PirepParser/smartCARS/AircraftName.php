<?php namespace vAMSYS\Services\PirepParser\smartCARS;

use vAMSYS\Pirep;
use vAMSYS\Services\PirepParser\Parser;

class AircraftName implements Parser {

    public static function parse($timestamp, $line, $matches, Pirep $pirep)
    {
        $pirep->pirep_data = array_merge($pirep->pirep_data, ['aircraft' => $matches[1]]);
        return $pirep;
    }
}
