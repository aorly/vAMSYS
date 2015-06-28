<?php namespace vAMSYS\Services\PirepParser\smartCARS;

use vAMSYS\Pirep;
use vAMSYS\Services\PirepParser\Parser;

class CruiseAltChanged implements Parser {

    public static function parse($timestamp, $line, $matches, Pirep $pirep)
    {
        return $pirep;
    }
}
