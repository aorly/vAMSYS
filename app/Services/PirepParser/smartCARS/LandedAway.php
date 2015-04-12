<?php namespace vAMSYS\Services\PirepParser\smartCARS;

use vAMSYS\Pirep;
use vAMSYS\Services\PirepParser\Parser;

class LandedAway implements Parser {

    public static function parse($timestamp, $line, $matches, Pirep $pirep)
    {
        $pirepData = $pirep->pirep_data;
        $landedAway = ["timestamp" => $timestamp, "distance" => $matches[1]];

        if (!array_key_exists('landed_away', $pirepData))
            $pirep->pirep_data = array_merge($pirepData, ['landed_away' => []]);

        $pirepData['landed_away'][] = $landedAway;

        $pirep->pirep_data = $pirepData;

        return $pirep;
    }
}
