<?php namespace vAMSYS\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use vAMSYS\Booking;
use vAMSYS\Repositories\PilotRepository;
use vAMSYS\Repositories\RoutesRepository;

class FlightsBookComposer {

  /**
   * Bind data to the view.
   *
   * @param  View  $view
   * @return void
   */
  public function compose(View $view)
  {
    $pilot = PilotRepository::getCurrentPilot();
    $currentLocation = $pilot->location;
    $lastBooking = Booking::where('pilot_id', '=', $pilot->id)->orderBy('created_at', 'desc')->first();
    if (count($lastBooking) == 1){
      $currentLocation = $lastBooking->route->arrivalAirport;
    }
    $view->with('currentLocation', $currentLocation);

    // Ordered flights list
    $sortedRoutes = [];
    $availableRoutes = RoutesRepository::getRoutesFrom($currentLocation);
    $view->with('availableRoutes', $availableRoutes);
    foreach ($availableRoutes as $route){
      $sortedRoutes[$route->arrivalAirport->region->country->continent][$route->arrivalAirport->region->country->name][$route->arrivalAirport->region->name][] = (object)$route->arrivalAirport->toArray();
    }

    $view->with('sortedRoutes', $sortedRoutes);
  }

}