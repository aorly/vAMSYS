<?php namespace vAMSYS\Http\Controllers\Staff;

use vAMSYS\Http\Requests;
use vAMSYS\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PilotsController extends Controller {

  public function __construct()
  {
    $this->middleware('airline-staff');
  }

  public function getIndex()
  {
    return view('staff.pilots.dashboard');
  }

  public function postAdd(Request $request)
  {
    $user = \vAMSYS\User::where('email', $request->input('email'))->first();
    $airline = \vAMSYS\Airline::find(Session::get('airlineId'));
    $airline->pilots()->save($user);

    return view('staff.pilots.dashboard');
  }

}
