<?php namespace vAMSYS\Services\PirepScorer\Speed;


use Carbon\Carbon;
use vAMSYS\Exceptions\UnsuccessfulScoringException;
use vAMSYS\Pirep;
use vAMSYS\Services\PirepScorer\Scorer;

class OverspeedPerSecondWithBuffer implements Scorer {

    public static function score(Pirep &$pirep, $rule)
    {
        // Let's count the overspeeds!
        $pirepData = $pirep->pirep_data;
        $points = 0;

        if (!array_key_exists('overspeeds', $pirepData))
            throw new UnsuccessfulScoringException;

        foreach ($pirepData['overspeeds'] as $key => $overspeed)
        {
            $start = new Carbon($overspeed['timestamp']);
            $end = new Carbon($pirepData['overspeeds_corrected'][$key]['timestamp']);
            $seconds = $start->diffInSeconds($end);
            $totalMultiplier = $seconds - $rule['buffer'];
            if ($totalMultiplier < 0)
                $totalMultiplier = 0;

            $points += $rule['points'] * $totalMultiplier;
        }

        if ($points == 0)
            throw new UnsuccessfulScoringException;

        return ['name' => $rule['name'], 'points' => $points];
    }

}
