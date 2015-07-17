<?php namespace vAMSYS\Services\PirepScorer\Flaps;

use Carbon\Carbon;
use vAMSYS\Exceptions\InsufficientScoringDataException;
use vAMSYS\Exceptions\UnsuccessfulScoringException;
use vAMSYS\Pirep;
use vAMSYS\Services\PirepScorer\Scorer;

class NotSetBeforeTakeoff implements Scorer {

    public static function score(Pirep &$pirep, $rule)
    {
        // Were flaps set to the minimum level before takeoff?
        $takeoffTime = new Carbon($pirep->departure_time);

        $pirepData = $pirep->pirep_data;
        foreach ($pirepData['flap_changes'] as $flapChange) {
            $flapTime = new Carbon($flapChange['timestamp']);
            if ($flapChange['to'] >= $rule['minLevel']
                && $flapChange['to'] <= $rule['maxLevel']
                && $flapTime->lt($takeoffTime)
            )
                throw new UnsuccessfulScoringException;
        }

        // Nothing matched!
        return ['name' => '', "points" => $rule['points']];
    }
}
