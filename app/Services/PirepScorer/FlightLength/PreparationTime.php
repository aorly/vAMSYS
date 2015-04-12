<?php namespace vAMSYS\Services\PirepScorer\FlightLength;

use Carbon\Carbon;
use vAMSYS\Exceptions\UnsuccessfulScoringException;
use vAMSYS\Pirep;
use vAMSYS\Services\PirepScorer\Scorer;

class PreparationTime implements Scorer {

    public static function score(Pirep &$pirep, $rule)
    {
        $pirepStart = new Carbon($pirep->pirep_start_time);
        $offBlocks = new Carbon($pirep->off_blocks_time);

        $length = $pirepStart->diffInMinutes($offBlocks);

        foreach ($rule['thresholds'] as $threshold){
            // Does the preparation time meet this threshold?
            if ($length >= $threshold['moreThan'] && $length <= $threshold['lessThan'])
                return ['name' => $threshold['name'], 'points' => $threshold['points']];
        }

        throw new UnsuccessfulScoringException();
    }
}
