<?php namespace vAMSYS\Services\PirepParser\smartCARS;

use vAMSYS\Pirep;
use vAMSYS\Services\PirepParser\Parser;

class FlapsGround implements Parser {

    public static function parse($timestamp, $line, $matches, Pirep $pirep)
    {
        $pirepData = $pirep->pirep_data;
        $flapsChange = ["timestamp" => $timestamp, "to" => $matches[1]];

        if (!array_key_exists('flap_changes', $pirepData))
            $pirep->pirep_data = array_merge($pirepData, ['flap_changes' => []]);

        $pirepData['flap_changes'][] = $flapsChange;

        $pirep->pirep_data = $pirepData;

        return $pirep;
    }
}
