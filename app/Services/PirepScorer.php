<?php namespace vAMSYS\Services;

use vAMSYS\Contracts\PirepScorer as PirepScorerContract;
use vAMSYS\Exceptions\InsufficientScoringDataException;
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
        // Reset Everything
        $pirepData = $pirep->pirep_data;
        if (array_key_exists('scores', $pirepData))
            $pirepData['scores'] = [];
        if (array_key_exists('scoring_errors', $pirepData))
            $pirepData['scoring_errors'] = [];
        if (array_key_exists('failed_automatic_scoring', $pirepData))
            $pirepData['failed_automatic_scoring'] = false;

        $pirep->pirep_data = $pirepData;

        $scoringRules = $pirep->booking->pilot->airline->scoring_rules;
        $totalpoints = $scoringRules['starting_points'];
        foreach($scoringRules['rules'] as $rule){
            try {
                $scorer = call_user_func_array(self::FUNCTION_PREFIX . $rule['scorer'] . '::score', [&$pirep, $rule]);
                $totalpoints += $scorer['points'];

                // Success!
                $pirepData = $pirep->pirep_data;
                if (!array_key_exists('scores', $pirepData))
                    $pirepData['scores'] = [];

                $pirepData['scores'][] = ['name' => ltrim($scorer['name'].' '.$rule['name']), 'points' => $scorer['points'], 'failure' => false];
                $pirep->pirep_data = $pirepData;
            } catch (UnsuccessfulScoringException $e) {
                // Rule could not be completed. Store on PIREP data for information
                $pirepData = $pirep->pirep_data;
                if (!array_key_exists('scoring_errors', $pirepData))
                    $pirepData['scoring_errors'] = [];

                $pirepData['scoring_errors'][] = [$rule['scorer'] => $rule];
                $pirep->pirep_data = $pirepData;
                continue;
            } catch (InsufficientScoringDataException $e) {
                // Rule could not be completed. Store on PIREP data for information
                $pirepData = $pirep->pirep_data;
                if (!array_key_exists('insufficient_data_scoring_errors', $pirepData))
                    $pirepData['insufficient_data_scoring_errors'] = [];

                $pirepData['insufficient_data_scoring_errors'][] = [$rule['scorer'] => $rule];
                $pirep->pirep_data = $pirepData;
                continue;
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

                $pirepData['scores'][] = ['name' => ltrim($scorer->name . ' ' . $rule['name']), 'points' => $scorer->points, 'failure' => true];
                $pirep->pirep_data = $pirepData;
                continue;
            }
        }

        $pirep->points = $totalpoints;
        return $pirep;
    }
}
