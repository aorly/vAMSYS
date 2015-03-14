<?php namespace vAMSYS\Services\PirepParser\smartCARS;

use vAMSYS\Pirep;
use vAMSYS\Services\PirepParser\Parser;

class Engine implements Parser {

    public static function parse($timestamp, $line, $matches, Pirep $pirep)
    {
        $engineStart = ["engine" => $matches[1], "status" => $matches[2], "timestamp" => $timestamp];
        $pirepData = $pirep->pirep_data;

        if (!array_key_exists('engines', $pirepData))
            $pirepData['engines'] = [];

        $pirepData['engines'][] = $engineStart;

        $pirep->pirep_data = $pirepData;

        return $pirep;
    }
}
