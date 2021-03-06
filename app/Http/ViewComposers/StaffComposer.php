<?php namespace vAMSYS\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use vAMSYS\Airline;
use vAMSYS\Pirep;
use vAMSYS\Repositories\PilotRepository;

class StaffComposer {

  /**
   * Bind data to the view.
   *
   * @param  View  $view
   * @return void
   */
  public function compose(View $view)
  {
    // Count airline PIREPs
    $totalPirepsCount = Pirep::fromAirline()->count();
    $view->with('airlinePirepsCount', $totalPirepsCount);
  }

}