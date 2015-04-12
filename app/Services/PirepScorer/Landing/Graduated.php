<?php namespace vAMSYS\Services\PirepScorer\Landing;

use vAMSYS\Exceptions\PirepFailureException;
use vAMSYS\Exceptions\UnsuccessfulScoringException;
use vAMSYS\Pirep;
use vAMSYS\Services\PirepScorer\Scorer;

class Graduated implements Scorer {

    public static function score(Pirep &$pirep, $rule)
    {
        foreach ($rule['thresholds'] as $threshold){
            // Does the landing meet this threshold?
            if ($pirep->landing_rate <= $threshold['lightest'] && $pirep->landing_rate >= $threshold['heaviest']){
                // Match!
                $points = $threshold['points'];
                if (array_key_exists('adjustment', $threshold)){
                    // Apply adjustments
                    if ($threshold['adjustment']['direction'] == 'lighter')
                        $points = $points + ($threshold['adjustment']['points'] * ($pirep->landing_rate -
                            $threshold['adjustment']['from']));

                    if ($threshold['adjustment']['direction'] == 'heavier')
                        $points = $points + ($threshold['adjustment']['points'] * ($threshold['adjustment']['from'] -
                            $pirep->landing_rate));
                }

                // Does this rule carry a failure condition?
                if (array_key_exists('failure', $threshold) && $threshold['failure'] === true){
                    $scorer = json_encode(['name' => $threshold['name'], 'points' => $points]);
                    throw new PirepFailureException($scorer);
                }

                return ['name' => $threshold['name'], 'points' => $points];
            }
        }

        throw new UnsuccessfulScoringException();
    }
}
