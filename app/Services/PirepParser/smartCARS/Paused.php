<?php namespace vAMSYS\Services\PirepParser\smartCARS;

use vAMSYS\Pirep;
use vAMSYS\Services\PirepParser\Parser;

class Paused implements Parser {

    public static function parse($timestamp, $line, $matches, Pirep $pirep)
    {
        $pirepData = $pirep->pirep_data;
        $pause = ["timestamp" => $timestamp];

        if (!array_key_exists('pauses', $pirepData))
            $pirep->pirep_data = array_merge($pirepData, ['pauses' => []]);

        $pirepData['pauses'][] = $pause;

        $pirep->pirep_data = $pirepData;

        return $pirep;
    }
}
