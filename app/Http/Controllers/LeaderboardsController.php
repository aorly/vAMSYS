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
        $data = Cache::get(PilotRepository::getCurrentPilot()->airline->prefix.':Leaderboards:Global');

		return view('leaderboards.global', ['data' => (object)$data]);
	}

}
