<?php namespace vAMSYS\Services\PirepParser\smartCARS;

use vAMSYS\Pirep;
use vAMSYS\Services\PirepParser\Parser;

class Pushback implements Parser {

    public static function parse($timestamp, $line, $matches, Pirep $pirep)
    {
        $pirep->pirep_data = array_merge($pirep->pirep_data, ['pushback' => ['timestamp' => $timestamp, 'fuel' =>
            $matches[1],
        'units' => $matches[2]]]);
        $pirep->off_blocks_time = $timestamp;
        return $pirep;
    }
}
