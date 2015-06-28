<?php namespace vAMSYS\Http\Controllers\Staff;

use Carbon\Carbon;
use vAMSYS\Http\Controllers\Controller;
use Illuminate\Http\Request;
use vAMSYS\Airport;
use Illuminate\Support\Facades\Session;
use vAMSYS\Pirep;
use vAMSYS\Services\Route;

class RoutesController extends Controller {

  public function __construct()
  {
    $this->middleware('airline-staff');
  }

  public function getIndex()
  {
    return view('staff.pireps.dashboard');
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
