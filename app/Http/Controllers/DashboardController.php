<?php namespace vAMSYS\Http\Controllers;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use vAMSYS\Airline;
use vAMSYS\Commands\FilePirep;
use vAMSYS\Events\PirepWasFiled;
use vAMSYS\Pirep;
use vAMSYS\SmartCARS_Session;

class DashboardController extends Controller {

	/**
	 * Create a new controller instance.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the dashboard to the user.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		return view('dashboard');
	}

    public function getTest()
    {
        // Save the PIREP and dispatch the event
        $pirep = new Pirep();
        $pirep->booking_id = 15;
        $pirep->landing_rate = -150;
        $pirep->fuel_used = 1000;
        $pirep->load = 0;
        $pirep->log = "smartCARS version 2.0.50.0, 2015/2/10 UTC[07:44:59 PM] Preflight started, flying offline[07:44:59 PM] Flying Boeing 737-8ASNGX Ryanair Winglets[07:44:59 PM] Engine 1 is on[07:44:59 PM] Engine 2 is on[07:45:11 PM] Flaps set to position 1[07:45:18 PM] Flaps set to position 2[07:45:22 PM] Flaps set to position 3[07:45:26 PM] Flaps set to position 4[07:45:30 PM] Flaps set to position 5[07:45:32 PM] Flaps set to position 6[07:45:36 PM] Flaps set to position 7[07:45:40 PM] Flaps set to position 8[07:45:51 PM] Pushing back with 10883 lb of fuel[07:45:51 PM] Taxiing to runway[07:45:56 PM] Taking off[07:46:08 PM] Climbing, pitch: 6, roll: 0, 138 kts[07:46:13 PM] Gear lever raised at 418 ft at 153 kts[07:46:23 PM] Flaps set to position 7 at 1053 ft at 157 kts[07:46:28 PM] Flaps set to position 6 at 1328 ft at 160 kts[07:46:31 PM] Flaps set to position 5 at 1530 ft at 161 kts[07:46:34 PM] Flaps set to position 4 at 1641 ft at 161 kts[07:46:37 PM] Flaps set to position 3 at 1780 ft at 162 kts[07:46:41 PM] Flaps set to position 2 at 1907 ft at 163 kts[07:46:45 PM] Flaps set to position 1 at 1993 ft at 164 kts[07:46:52 PM] Flaps set to position 0 at 2004 ft at 166 kts[07:46:54 PM] Cruising at 1500ft, pitch: 5, 171 kts[07:46:57 PM] Descending[07:46:57 PM] Approaching[07:46:57 PM] Final approach, 171 kts[07:48:27 PM] Go around conditions met[07:48:41 PM] Standard final approach conditions met[07:49:25 PM] Gear lever lowered at 1266 ft at 168 kts[07:49:29 PM] Flaps set to position 7 at 1215 ft at 165 kts[07:49:46 PM] Go around conditions met[07:49:47 PM] Flaps set to position 3 at 1238 ft at 156 kts[07:49:51 PM] Flaps set to position 4 at 1335 ft at 156 kts[07:49:54 PM] Flaps set to position 5 at 1401 ft at 156 kts[07:49:57 PM] Flaps set to position 6 at 1445 ft at 157 kts[07:50:00 PM] Flaps set to position 7 at 1545 ft at 156 kts[07:50:05 PM] Flaps set to position 8 at 1722 ft at 157 kts[07:50:11 PM] Standard final approach conditions met[07:51:56 PM] Touched down at -93 fpm, gear lever: down, pitch: 3, roll: -1, 114 kts[07:52:08 PM] Landed in 1643 ft, fuel: 10076 lb, weight: 101376 lb[07:52:08 PM] Taxiing to gate[07:52:11 PM] The flight may now be ended[07:52:11 PM] Taxi time was less than 15 seconds[07:52:11 PM] Arrived, flight duration: 00:05[07:52:16 PM] Engine 2 is off[07:52:17 PM] Engine 1 is off";
        $pirep->save();

        $pilot = SmartCARS_Session::where('pilot_id', '=', 2)->where('sessionid', '=', 'kJa4ydo2M6LBzEDzqVELHJ8VciDQwIZWeNFCYW9JTUOjCfHlIfu1r0vhb5w3aQzm')->first()->pilot;

        Event::fire(new PirepWasFiled($pirep, $pilot));
    }

}
