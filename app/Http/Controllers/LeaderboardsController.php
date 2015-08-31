<?php namespace vAMSYS\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use vAMSYS\Pirep;
use vAMSYS\Repositories\PilotRepository;

class LeaderboardsController extends Controller {

	/**
	 * Create a new controller instance.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the global leaderboards to the user.
	 *
	 * @return Response
	 */
	public function getIndex()
    {
        // Collect statistics if required
        $data = Cache::remember(PilotRepository::getCurrentPilot()->airline->prefix.':Leaderboards:Global', 15, function(){

            $pirepsByUser = null;
            Pirep::where('pirep_data', '!=', '{"jumpseat":true}')->chunk(100, function ($pirepsChunk) use (&$pirepsByUser) { // TODO Improve this detection...
                $pirepsByUser = $pirepsChunk->groupBy(function ($item, $key) {
                    return $item->booking->pilot->id;
                });
            });

            // Most Points
            $pointsPirepsByUser = $pirepsByUser->sortByDesc(function (&$item, $key){
                $totalPoints = 0;
                foreach ($item as $pirep){
                    $totalPoints += $pirep->points;
                }
                $item->totalPoints = $totalPoints;
                return $totalPoints;
            });

            // Most Hours
            $timePirepsByUser = $pirepsByUser->sortByDesc(function (&$item, $key){
                $totalSeconds = 0;
                foreach ($item as $pirep){
                    $totalSeconds += $pirep->landing_time->getTimestamp() - $pirep->departure_time->getTimestamp();
                }
                $item->totalInterval = Carbon::now()->addSeconds($totalSeconds);
                return $totalSeconds;
            });

            // Most PIREPs
            $countPirepsByUser = $pirepsByUser->sortByDesc(function ($item, $key){
                return count($item);
            });

            return [
                'pirepCounts' => $countPirepsByUser->slice(0, 30),
                'pirepHours' => $timePirepsByUser->slice(0, 30),
                'pirepPoints' => $pointsPirepsByUser->slice(0, 30)
            ];

        });

		return view('leaderboards.global', ['data' => (object)$data]);
	}

}
