<?php namespace vAMSYS\Services\PirepScorer;

use vAMSYS\Pirep;

interface Scorer {
    public static function score(Pirep $pirep, $rule);
}
