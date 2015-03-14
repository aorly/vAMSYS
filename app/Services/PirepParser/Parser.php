<?php namespace vAMSYS\Services\PirepParser;

use vAMSYS\Pirep;

interface Parser {
    public static function parse($timestamp, $line, $matches, Pirep $pirep);
}
