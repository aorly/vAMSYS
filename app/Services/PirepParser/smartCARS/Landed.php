<?php namespace vAMSYS\Services\PirepParser\smartCARS;

use vAMSYS\Pirep;
use vAMSYS\Services\PirepParser\Parser;

class Landed implements Parser
{

    public static function parse($timestamp, $line, $matches, Pirep $pirep)
    {
        $pirep->pirep_data = array_merge($pirep->pirep_data, ['landing' =>
            ["length" => $matches[1],
                "fuel" => $matches[2],
                "fuel_unit" => $matches[3],
                "weight" => $matches[4],
                "weight_unit" => $matches[5]]]);
        return $pirep;
    }
}
