<?php namespace vAMSYS\Services\PirepParser\smartCARS;

use vAMSYS\Pirep;
use vAMSYS\Services\PirepParser\Parser;

class FinalApproachMet implements Parser {

    public static function parse($timestamp, $line, $matches, Pirep $pirep)
    {
        $pirepData = $pirep->pirep_data;
        $finalApproachMet = ["timestamp" => $timestamp];

        if (!array_key_exists('final_approach_met', $pirepData))
            $pirep->pirep_data = array_merge($pirepData, ['final_approach_met' => []]);

        $pirepData['final_approach_met'][] = $finalApproachMet;

        $pirep->pirep_data = $pirepData;

        return $pirep;
    }
}
