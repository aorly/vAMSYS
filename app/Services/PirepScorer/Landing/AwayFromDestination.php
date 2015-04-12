<?php namespace vAMSYS\Services\PirepScorer\Landing;

use vAMSYS\Exceptions\PirepFailureException;
use vAMSYS\Exceptions\UnsuccessfulScoringException;
use vAMSYS\Pirep;
use vAMSYS\Services\PirepScorer\Scorer;

class AwayFromDestination implements Scorer {

    public static function score(Pirep &$pirep, $rule)
    {
        // Did the pilot land away from the destination airport?
        $pirepData = $pirep->pirep_data;
        if (array_key_exists('landed_away', $pirepData)){
            // Yes!
            if (array_key_exists('failure', $rule) && $rule['failure'] === true){
                $scorer = json_encode(['name' => $rule['name'], 'points' => $rule['points']]);
                throw new PirepFailureException($scorer);
            }

            if ($rule['points'] !== 0)
                return ['name' => $rule['name'], 'points' => $rule['points']];
        }

        throw new UnsuccessfulScoringException();
    }
}
