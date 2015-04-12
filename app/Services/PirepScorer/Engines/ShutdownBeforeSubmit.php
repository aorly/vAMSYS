<?php namespace vAMSYS\Services\PirepScorer\Engines;

use Carbon\Carbon;
use vAMSYS\Exceptions\InsufficientScoringDataException;
use vAMSYS\Exceptions\UnsuccessfulScoringException;
use vAMSYS\Pirep;
use vAMSYS\Services\PirepScorer\Scorer;

class ShutdownBeforeSubmit implements Scorer {

    public static function score(Pirep $pirep, $rule)
    {
        // Were engines switched off before submission?
        $submissionTime = new Carbon($pirep->pirep_end_time);

        $data = $pirep->pirep_data;
        $engines = [];
        $pirepEngines = array_reverse($data['engines']);
        foreach ($pirepEngines as $engineChange)
        {
            if ($engineChange['status'] != 'off')
                continue;

            if (array_key_exists($engineChange['engine'], $engines))
                continue;

            $engines[$engineChange['engine']] = new Carbon($engineChange['timestamp']);
        }

        if (count($engines) < 2)
            throw new InsufficientScoringDataException();

        if ($engines[1]->lt($submissionTime) && $engines[2]->lt($submissionTime))
            return ['name' => '', 'points' => $rule['points']];

        throw new UnsuccessfulScoringException();
    }
}
