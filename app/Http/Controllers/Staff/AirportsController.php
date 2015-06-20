<?php namespace vAMSYS\Http\Controllers\Staff;

use vAMSYS\Http\Controllers\Controller;
use Illuminate\Http\Request;
use vAMSYS\Airport;
use vAMSYS\Airline;
use Illuminate\Support\Facades\Session;

class AirportsController extends Controller {

  public function __construct()
  {
    $this->middleware('airline-staff');
  }

  public function getIndex()
  {
    return view('staff.airports.dashboard');
  }
  
  public function postAdd(Request $request)
  {
    $airport = $request->input('icao');
    $airportId = Airport::where('icao', $airport)->first();
    $airline = Airline::find(Session::get('airlineId'));
    $airline->airports()->save($airportId);

    return view('staff.airports.dashboard');
  }

}
