<?php namespace vAMSYS\Services\PirepParser\smartCARS;

use vAMSYS\Pirep;
use vAMSYS\Services\PirepParser\Parser;

class OverspeedBelowFL100 implements Parser {

    public static function parse($timestamp, $line, $matches, Pirep $pirep)
    {
        $pirepData = $pirep->pirep_data;
        $overspeed = ["timestamp" => $timestamp, "speed" => $matches[1], "altitude" => $matches[2]];

        if (!array_key_exists('overspeeds_fl100', $pirepData))
            $pirep->pirep_data = array_merge($pirepData, ['overspeeds_fl100' => []]);

        $pirepData['overspeeds_fl100'][] = $overspeed;

        $pirep->pirep_data = $pirepData;

        return $pirep;
    }
}
