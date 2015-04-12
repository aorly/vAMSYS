<?php namespace vAMSYS\Services\PirepScorer\FlightLength;

use Carbon\Carbon;
use vAMSYS\Exceptions\UnsuccessfulScoringException;
use vAMSYS\Pirep;
use vAMSYS\Services\PirepScorer\Scorer;

class MinuteThresholds implements Scorer {

    public static function score(Pirep &$pirep, $rule)
    {
        $flightStart = new Carbon($pirep->departure_time);
        $flightEnd = new Carbon($pirep->landing_time);

        $length = $flightStart->diffInMinutes($flightEnd);

        foreach ($rule['thresholds'] as $threshold){
            // Does the flight length meet this threshold?
            if ($length >= $threshold['moreThan'] && $length <= $threshold['lessThan'])
                return ['name' => $threshold['name'], 'points' => $threshold['points']];
        }

        throw new UnsuccessfulScoringException();
    }
}
