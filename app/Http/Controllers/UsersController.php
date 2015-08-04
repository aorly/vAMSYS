<?php namespace vAMSYS\Http\Controllers;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use vAMSYS\Airline;
use vAMSYS\Commands\FilePirep;
use vAMSYS\Events\PirepWasFiled;
use vAMSYS\Pilot;
use vAMSYS\Pirep;
use vAMSYS\Repositories\PilotRepository;
use vAMSYS\SmartCARS_Session;

class UsersController extends Controller {

	/**
	 * Create a new controller instance.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function getProfile(Pilot $pilot)
	{
        $myProfile = ($pilot->id == PilotRepository::getCurrentPilot()->id);
		return view('profile.main', ['me' => $myProfile, 'thePilot' => $pilot]);
	}

    public function getOwnProfile()
    {
        return $this->getProfile(PilotRepository::getCurrentPilot());
    }

}
