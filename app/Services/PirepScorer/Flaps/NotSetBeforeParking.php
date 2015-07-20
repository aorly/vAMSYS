<?php namespace vAMSYS\Services\PirepScorer\Flaps;

use Carbon\Carbon;
use vAMSYS\Exceptions\InsufficientScoringDataException;
use vAMSYS\Exceptions\UnsuccessfulScoringException;
use vAMSYS\Pirep;
use vAMSYS\Services\PirepScorer\Scorer;

class NotRetractedBeforeParking implements Scorer {

    public static function score(Pirep &$pirep, $rule)
    {
        // Were flaps set to the minimum level before parking?
        $parkingTime = new Carbon($pirep->on_blocks_time);

        $pirepData = $pirep->pirep_data;
        foreach ($pirepData['flap_changes'] as $flapChange) {
            $flapTime = Carbon::parse($flapChange['timestamp']['date'], $flapChange['timestamp']['timezone']);
            if ($flapChange['to'] === 0 && $flapTime->lt($parkingTime))
                throw new UnsuccessfulScoringException; // Flaps set successfully
        }

        // Nothing matched!
        return ['name' => $rule['name'], "points" => $rule['points']];
    }
}
