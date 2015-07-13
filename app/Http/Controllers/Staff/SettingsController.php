<?php namespace vAMSYS\Http\Controllers\Staff;

use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use vAMSYS\Airline;
use vAMSYS\Events\PirepWasFiled;
use vAMSYS\Events\PirepWasProcessed;
use vAMSYS\Http\Controllers\Controller;
use vAMSYS\Pirep;
use vAMSYS\Services\Route;

class SettingsController extends Controller {

    public function __construct()
    {
        $this->middleware('airline-staff');
    }

    public function getScoring()
    {
        $airline = Airline::find(Session::get('airlineId'));

        return view('staff.settings.scoringRules', ['scoringRulesJSON' => json_encode($airline->scoring_rules['rules'])]);
    }

}
