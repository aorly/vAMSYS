<?php namespace vAMSYS\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use vAMSYS\Booking;
use vAMSYS\Contracts\Route;
use vAMSYS\Repositories\PilotRepository;
use vAMSYS\Repositories\RoutesRepository;

class FlightsComposer {

  /**
   * Bind data to the view.
   *
   * @param Route $route
   * @param  View $view
   */
  public function compose(Route $route, View $view)
  {
    $pilot = PilotRepository::getCurrentPilot();
    $currentBooking = Booking::where('pilot_id', '=', $pilot->id)->first();
    $view->with('currentBooking', $currentBooking);
    $view->with('upcomingBookings', Booking::limit(10)->skip(1)->where('pilot_id', '=', $pilot->id)->get());
    $view->with('routePoints', $route->getAllPointsForRoute($currentBooking->route));
  }

}