<?php namespace vAMSYS\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use vAMSYS\Booking;
use vAMSYS\Repositories\PilotRepository;
use vAMSYS\Services\Route;

class FlightsComposer {

  /**
   * Bind data to the view.
   *
   * @param Route $route
   * @param  View $view
   */
  public function compose(View $view)
  {
    $routeService = new Route();
    $pilot = PilotRepository::getCurrentPilot();
    $currentBooking = Booking::has('pirep', '<', 1)->where('pilot_id', '=', $pilot->id)->first();
    $view->with('currentBooking', $currentBooking);
    $view->with('upcomingBookings', Booking::has('pirep', '<', 1)->limit(10)->skip(1)->where('pilot_id', '=',
            $pilot->id)->get());
    $view->with('routePoints', $routeService->getAllPointsForRoute($currentBooking->route));
  }

}
