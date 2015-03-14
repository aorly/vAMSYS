<?php namespace vAMSYS\Services\PirepParser\smartCARS;

use vAMSYS\Pirep;
use vAMSYS\Services\PirepParser\Parser;

class Gear implements Parser {

    public static function parse($timestamp, $line, $matches, Pirep $pirep)
    {
        $pirepData = $pirep->pirep_data;
        $gearChange = [
            "timestamp" => $timestamp,
            "status" => $matches[1],
            "altitude" => $matches[2],
            "speed" => $matches[3]];

        if (!array_key_exists('gear_changes', $pirepData))
            $pirep->pirep_data = array_merge($pirepData, ['gear_changes' => []]);

        $pirepData['gear_changes'][] = $gearChange;

        $pirep->pirep_data = $pirepData;

        return $pirep;
    }
}
