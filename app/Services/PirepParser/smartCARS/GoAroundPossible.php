<?php namespace vAMSYS\Services\PirepParser\smartCARS;

use vAMSYS\Pirep;
use vAMSYS\Services\PirepParser\Parser;

class GoAroundPossible implements Parser {

    public static function parse($timestamp, $line, $matches, Pirep $pirep)
    {
        $pirepData = $pirep->pirep_data;
        $goAroundPossible = ["timestamp" => $timestamp];

        if (!array_key_exists('go_around_possible', $pirepData))
            $pirep->pirep_data = array_merge($pirepData, ['go_around_possible' => []]);

        $pirepData['go_around_possible'][] = $goAroundPossible;

        $pirep->pirep_data = $pirepData;

        return $pirep;
    }
}
