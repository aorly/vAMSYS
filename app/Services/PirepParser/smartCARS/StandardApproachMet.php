<?php namespace vAMSYS\Services\PirepParser\smartCARS;

use vAMSYS\Pirep;
use vAMSYS\Services\PirepParser\Parser;

class StandardApproachMet implements Parser {

    public static function parse($timestamp, $line, $matches, Pirep $pirep)
    {
        $pirepData = $pirep->pirep_data;
        $standardApproachMet = ["timestamp" => $timestamp];

        if (!array_key_exists('standard_approach_met', $pirepData))
            $pirep->pirep_data = array_merge($pirepData, ['standard_approach_met' => []]);

        $pirepData['standard_approach_met'][] = $standardApproachMet;

        $pirep->pirep_data = $pirepData;

        return $pirep;
    }
}
