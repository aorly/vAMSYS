<?php namespace vAMSYS\Http\Controllers;

use Carbon\Carbon;
use vAMSYS\Pirep;
use vAMSYS\Repositories\PilotRepository;
use vAMSYS\Services\Route;

class PirepsController extends Controller {

    /**
	 * Create a new controller instance.
	 */
	public function __construct()
	{
		$this->middleware('auth');
    }

    public function getIndex()
    {
        return view('pireps/list', ['pireps' => PilotRepository::getCurrentPilotPireps()]);
    }

    public function getSinglePirep(Pirep $pirep)
    {
        // Do we have access to this PIREP?
        if ($pirep->booking->pilot->id !== PilotRepository::getCurrentPilot()->id)
            return redirect('/pireps');

        // Calculate some data bits (keep it out of the view)
        $extras = [];

        // Airborne Time
        $takeoff = new Carbon($pirep->departure_time);
        $landing = new Carbon($pirep->landing_time);
        $extras['airborneTime'] = $takeoff->diff($landing);

        // Blocks Time
        $offBlocks = new Carbon($pirep->off_blocks_time);
        $onBlocks = new Carbon($pirep->on_blocks_time);
        $extras['blocksTime'] = $offBlocks->diff($onBlocks);

        // Total Time
        $start = new Carbon($pirep->pirep_start_time);
        $finish = new Carbon($pirep->pirep_end_time);
        $extras['totalTime'] = $start->diff($finish);

        // Planned Route
        $routeService = new Route();
        $extras['routePoints'] = $routeService->getAllPointsForRoute($pirep->booking->route);

        // Format Text Log (ugly, I know!)
        $extras['log'] = str_replace('[', '
[', $pirep->log);

        // Display the PIREP!
        return view('pireps/single', ['pirep' => $pirep, 'extras' => $extras]);
    }

}
