<?php namespace vAMSYS\Http\Controllers;

use Illuminate\Support\Facades\Event;
use vAMSYS\Events\PirepWasProcessed;
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
        $pirep = PilotRepository::getCurrentPilot()->pireps[0];
        Event::fire(new PirepWasProcessed($pirep));
	}

}
