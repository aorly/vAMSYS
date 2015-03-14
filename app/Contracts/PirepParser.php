<?php namespace vAMSYS\Contracts;

use vAMSYS\Pirep;

interface PirepParser
{
    public function __construct($acarsId);
    public function parseLine($timestamp, $line, Pirep $pirep);
}
