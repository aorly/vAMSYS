<?php namespace vAMSYS\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use vAMSYS\Airline;
use vAMSYS\Repositories\PilotRepository;

class GlobalComposer {

  /**
   * Bind data to the view.
   *
   * @param  View  $view
   * @return void
   */
  public function compose(View $view)
  {
    // Are we connecting from a known URL?
    if($airline = Airline::where('url', '=', Request::getHttpHost())->first())
      Session::put('airlineId', $airline->id);

    if (Session::has('airlineId'))
      $view->with('airline', Airline::find(Session::get('airlineId')));

    if (Request::user()) {
      $view->with('user', Request::user());
      $view->with('pilot', PilotRepository::getCurrentPilot());
    }
  }

}
