<?php namespace vAMSYS\Http\Controllers\Staff;

use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use vAMSYS\Events\PirepWasFiled;
use vAMSYS\Events\PirepWasProcessed;
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
        $failedPireps = Pirep::fromAirline()->where('status', '=', 'failed')->get();

        return view('staff.pireps.dashboard', ['pireps' => $pireps, 'failedPireps' => $failedPireps]);
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
        return view('pireps/single', ['pirep' => $pirep, 'extras' => $extras, 'staffBar' => true]);
    }

    public function getAccept(Pirep $pirep){
        $pirep->status = 'accepted';
        $pirep->save();

        return redirect('/staff/pireps')->with('flash', 'PIREP ID '.$pirep->id.' was accepted');
    }

    public function getReject(Pirep $pirep){
        $pirep->status = 'rejected';
        $pirep->save();

        return redirect('/staff/pireps')->with('flash', 'PIREP ID '.$pirep->id.' was rejected');
    }

    public function getReprocess(Pirep $pirep){
        Event::fire(new PirepWasFiled($pirep, $pirep->booking->pilot, true));
        return back()->with('flash', 'This PIREP has been submitted for reprocessing');
    }

    public function getRescore(Pirep $pirep){
        Event::fire(new PirepWasProcessed($pirep, $pirep->booking->pilot, true));
        return back()->with('flash', 'This PIREP has been submitted for rescoring');
    }

    public function getReprocessAll(){
        $pireps = Pirep::all();
        foreach ($pireps as $pirep){
            Event::fire(new PirepWasFiled($pirep, $pirep->booking->pilot, true));
        }
        return redirect('/staff/pireps')->with('flash', 'All PIREPs have been submitted for reprocessing');
    }

    public function getRescoreAll(){
        $pireps = Pirep::all();
        foreach ($pireps as $pirep){
            Event::fire(new PirepWasProcessed($pirep, $pirep->booking->pilot, true));
        }
        return redirect('/staff/pireps')->with('flash', 'All PIREPs have been submitted for rescoring');
    }

}
