<?php namespace vAMSYS\Services\PirepParser\smartCARS;

use vAMSYS\Pirep;
use vAMSYS\Services\PirepParser\Parser;

class Arrived implements Parser {

    public static function parse($timestamp, $line, $matches, Pirep $pirep)
    {
        $pirep->on_blocks_time = $timestamp;
        return $pirep;
    }
}
