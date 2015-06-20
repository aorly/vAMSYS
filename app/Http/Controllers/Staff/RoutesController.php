<?php namespace vAMSYS\Http\Controllers\Staff;

use vAMSYS\Http\Controllers\Controller;
use Illuminate\Http\Request;
use vAMSYS\Airport;
use Illuminate\Support\Facades\Session;

class RoutesController extends Controller {

  public function __construct()
  {
    $this->middleware('airline-staff');
  }

  public function getIndex()
  {
    return view('staff.routes.dashboard');
  }
  
  public function postAdd(Request $request)
  {
    $from = Airport::where('icao', $request->input('from'))->first();
    $to = Airport::where('icao', $request->input('to'))->first();

    $route = new \vAMSYS\Route();
    $route->departure_id = $from->id;
    $route->arrival_id = $to->id;
    $route->route = $request->input('route');
    $route->airline_id = Session::get('airlineId');
    $route->save();

    return view('staff.routes.dashboard');
  }

}
