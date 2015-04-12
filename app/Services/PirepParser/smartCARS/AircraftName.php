<?php namespace vAMSYS\Services\PirepParser\smartCARS;

use vAMSYS\Pirep;
use vAMSYS\Services\PirepParser\Parser;

class AircraftName implements Parser {

    public static function parse($timestamp, $line, $matches, Pirep $pirep)
    {
        $pirepData = $pirep->pirep_data;
        $pirepData['aircraft'] = $matches[1];
        $pirep->pirep_data = $pirepData;
        return $pirep;
    }
}
