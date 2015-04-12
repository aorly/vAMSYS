<?php namespace vAMSYS\Services\PirepParser\smartCARS;

use vAMSYS\Pirep;
use vAMSYS\Services\PirepParser\Parser;

class OverspeedCorrected implements Parser {

    public static function parse($timestamp, $line, $matches, Pirep $pirep)
    {
        $pirepData = $pirep->pirep_data;
        $overspeedCorrected = ["timestamp" => $timestamp, "max_speed" => $matches[1]];

        if (!array_key_exists('overspeeds_corrected', $pirepData))
            $pirep->pirep_data = array_merge($pirepData, ['overspeeds_corrected' => []]);

        $pirepData['overspeeds_corrected'][] = $overspeedCorrected;

        $pirep->pirep_data = $pirepData;

        return $pirep;
    }
}
