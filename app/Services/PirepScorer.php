<?php namespace vAMSYS\Services;

use vAMSYS\Contracts\PirepScorer as PirepScorerContract;
use vAMSYS\Exceptions\PirepFailureException;
use vAMSYS\Exceptions\UnsuccessfulScoringException;
use vAMSYS\Pirep;

/**
 * Class PirepScorer
 * @package vAMSYS\Services
 */
class PirepScorer implements PirepScorerContract
{
    const FUNCTION_PREFIX = 'vAMSYS\\Services\\PirepScorer\\';


    public static function score(Pirep $pirep)
    {
        $scoringRules = $pirep->booking->pilot->airline->scoring_rules;
        $totalpoints = $scoringRules['starting_points'];
        foreach($scoringRules['rules'] as $rule){
            try {
                $scorer = call_user_func(self::FUNCTION_PREFIX . $rule['scorer'] . '::score', &$pirep, $rule);
                $totalpoints += $scorer['points'];

                // Success!
                $pirepData = $pirep->pirep_data;
                if (!array_key_exists('scores', $pirepData))
                    $pirepData['scores'] = [];

                $pirepData['scores'][ltrim($scorer['name'].' '.$rule['name'])] = $scorer['points'];
                $pirep->pirep_data = $pirepData;

                dump(self::FUNCTION_PREFIX . $rule['scorer'] . ' scores '.$scorer['points']);
            } catch (UnsuccessfulScoringException $e) {
                // Rule could not be completed. Store on PIREP data for information
                $pirepData = $pirep->pirep_data;
                if (!array_key_exists('scoring_errors', $pirepData))
                    $pirepData['scoring_errors'] = [];

                $pirepData['scoring_errors'][] = [$rule['scorer'] => $rule];
                $pirep->pirep_data = $pirepData;
                dump(self::FUNCTION_PREFIX . $rule['scorer'] . ' could not complete');
            } catch (PirepFailureException $e) {
                // Pirep should be failed. Store on PIREP, apply points, continue processing!
                $pirepData = $pirep->pirep_data;
                $pirepData['failed_automatic_scoring'] = true;
                $pirep->pirep_data = $pirepData;

                $scorer = json_decode($e->getMessage());
                $totalpoints += $scorer->points;

                $pirepData = $pirep->pirep_data;
                if (!array_key_exists('scores', $pirepData))
                    $pirepData['scores'] = [];

                $pirepData['scores'][ltrim($scorer->name.' '.$rule['name'])] = $scorer->points;
                $pirep->pirep_data = $pirepData;

                dump(self::FUNCTION_PREFIX . $rule['scorer'] . ' scores '.$scorer->points.', and failed the PIREP');
            }
        }
        dd($pirep);
    }
}