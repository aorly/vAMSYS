<?php namespace vAMSYS\Http\Controllers\Staff;

use vAMSYS\Http\Requests;
use vAMSYS\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use vAMSYS\Pilot;

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
    $pilot = new Pilot();
    $pilot->username = $request->input('username');
    $pilot->rank_id = 1;
    $pilot->user_id = $user->id;
    $pilot->airline_id = Session::get('airlineId');
    $pilot->location_id = 16515;
    $pilot->save();

    return view('staff.pilots.dashboard');
  }

}
