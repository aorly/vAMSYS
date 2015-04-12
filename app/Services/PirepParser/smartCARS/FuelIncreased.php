<?php namespace vAMSYS\Services\PirepParser\smartCARS;

use vAMSYS\Pirep;
use vAMSYS\Services\PirepParser\Parser;

class FuelIncreased implements Parser {

    public static function parse($timestamp, $line, $matches, Pirep $pirep)
    {
        $pirepData = $pirep->pirep_data;
        $fuelChange = ["timestamp" => $timestamp, "change" => "increased", "from" => $matches[3], "to" =>
            $matches[1], "from_unit" => $matches[4], "to_unit" => $matches[2]];

        if (!array_key_exists('fuel_changes', $pirepData))
            $pirep->pirep_data = array_merge($pirepData, ['fuel_changes' => []]);

        $pirepData['fuel_changes'][] = $fuelChange;

        $pirep->pirep_data = $pirepData;

        return $pirep;
    }
}
