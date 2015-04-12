<?php namespace vAMSYS\Services\PirepParser\smartCARS;

use vAMSYS\Pirep;
use vAMSYS\Services\PirepParser\Parser;

class Unpaused implements Parser {

    public static function parse($timestamp, $line, $matches, Pirep $pirep)
    {
        $pirepData = $pirep->pirep_data;
        $unpause = ["timestamp" => $timestamp];

        if (!array_key_exists('unpauses', $pirepData))
            $pirep->pirep_data = array_merge($pirepData, ['unpauses' => []]);

        $pirepData['unpauses'][] = $unpause;

        $pirep->pirep_data = $pirepData;

        return $pirep;
    }
}
