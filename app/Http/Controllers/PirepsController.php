<?php namespace vAMSYS\Http\Controllers;

use Illuminate\Support\Facades\Event;
use vAMSYS\Events\PirepWasFiled;
use vAMSYS\Repositories\PilotRepository;

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
        // Test!
        $pirep = PilotRepository::getCurrentPilot()->pireps[1];
        Event::fire(new PirepWasFiled($pirep, PilotRepository::getCurrentPilot()));
	}

}
