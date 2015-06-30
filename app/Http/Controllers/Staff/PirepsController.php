<?php namespace vAMSYS\Http\Controllers\Staff;

use Carbon\Carbon;
use vAMSYS\Http\Controllers\Controller;
use vAMSYS\Pirep;
use vAMSYS\Services\Route;

class PirepsController extends Controller {

    public function __construct()
    {
        $this->middleware('airline-staff');
    }

    public function getIndex()
    {
        $pireps = Pirep::fromAirline()->get();
        $pireps->load([
            'booking' => function ($query){
                $query->withTrashed(); // Include "deleted" bookings
            },
            'booking.route' => function ($query){
                $query->withTrashed(); // Include "deleted" routes
            },
            'booking.pilot.user'
        ]);

        dd($pireps);

        return view('staff.pireps.dashboard', ['pireps' => $pireps]);
    }

    public function getView(Pirep $pirep){
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
