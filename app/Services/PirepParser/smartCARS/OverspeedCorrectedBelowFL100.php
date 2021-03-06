<?php namespace vAMSYS\Services\PirepParser\smartCARS;

use vAMSYS\Pirep;
use vAMSYS\Services\PirepParser\Parser;

class OverspeedCorrectedBelowFL100 implements Parser {

    public static function parse($timestamp, $line, $matches, Pirep $pirep)
    {
        $pirepData = $pirep->pirep_data;
        $overspeedCorrected = ["timestamp" => $timestamp, "altitude" => $matches[1], "max_speed" => $matches[2]];

        if (!array_key_exists('overspeeds_fl100_corrected', $pirepData))
            $pirep->pirep_data = array_merge($pirepData, ['overspeeds_fl100_corrected' => []]);

        $pirepData['overspeeds_fl100_corrected'][] = $overspeedCorrected;

        $pirep->pirep_data = $pirepData;

        return $pirep;
    }
}
