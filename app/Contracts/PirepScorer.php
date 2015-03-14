<?php namespace vAMSYS\Contracts;

use vAMSYS\Pirep;

interface PirepScorer
{
    public static function score(Pirep $pirep);
}
