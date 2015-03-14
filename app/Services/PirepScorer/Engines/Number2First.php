<?php namespace vAMSYS\Services\PirepScorer\Engines;

use Carbon\Carbon;
use vAMSYS\Exceptions\InsufficientScoringDataException;
use vAMSYS\Exceptions\UnsuccessfulScoringException;
use vAMSYS\Pirep;
use vAMSYS\Services\PirepScorer\Scorer;

class Number2First implements Scorer {

    public static function score(Pirep $pirep, $rule)
    {
        // Was engine 2 started first?
        $data = $pirep->pirep_data;
        $engines = [];
        foreach ($data['engines'] as $engineChange)
        {
            if ($engineChange['status'] != 'on')
                continue;

            if (array_key_exists($engineChange['engine'], $engines))
                continue;

            $engines[$engineChange['engine']] = new Carbon($engineChange['timestamp']);
        }

        if (count($engines) < 2)
            throw new InsufficientScoringDataException();

        if ($engines[2]->lt($engines[1]))
            return ['name' => '', 'points' => $rule['points']];

        throw new UnsuccessfulScoringException();
    }
}
