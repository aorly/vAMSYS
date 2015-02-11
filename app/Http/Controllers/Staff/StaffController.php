<?php namespace vAMSYS\Http\Controllers\Staff;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use vAMSYS\Commands\ParseTextDataCommand;
use vAMSYS\Http\Controllers\Controller;
use vAMSYS\Repositories\PilotRepository;

class StaffController extends Controller {

  /**
   * Create a new controller instance.
   */
  public function __construct()
  {
    $this->middleware('airline-staff');
  }

  /**
   * Show the dashboard to the user.
   *
   * @return Response
   */
  public function getIndex()
  {
    return view('staff.dashboard');
  }

  public function postPayment(Request $request)
  {
    $airline = PilotRepository::getCurrentPilot()->airline;
    $airline->subscription('250Pilots')->create($request->input('stripeToken'), [
      'description' => 'Subscription for: '.PilotRepository::getCurrentPilot()->airline->name,
      'email' => Auth::user()->email
    ]);
    dd('done');
  }

}
