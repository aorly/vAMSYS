<?php namespace vAMSYS\Http\Controllers\Staff;

use vAMSYS\Http\Requests;
use vAMSYS\Http\Controllers\Controller;

class PilotsController extends Controller {

  public function __construct()
  {
    $this->middleware('airline-staff');
  }

  public function getIndex()
  {
    return view('staff.pilots.dashboard');
  }

}
