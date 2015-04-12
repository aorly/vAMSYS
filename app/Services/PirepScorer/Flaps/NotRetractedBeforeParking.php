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
        $landingTime = new Carbon($pirep->landing_time);

        $pirepData = $pirep->pirep_data;
        // Work from the end of the flap changes array
        $flapChanges = array_reverse($pirepData['flap_changes']);
        foreach ($flapChanges as $flapChange) {
            $flapTime = new Carbon($flapChange['timestamp']);
            if ($flapChange['to'] == 0 && $flapTime->gt($landingTime) && $flapTime->lte($parkingTime))
                throw new UnsuccessfulScoringException; // Flaps set successfully
        }

        // Nothing matched!
        return ['name' => $rule['name'], "points" => $rule['points']];
    }
}
