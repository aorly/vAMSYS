<?php namespace vAMSYS\Services;

use vAMSYS\Contracts\Route as RouteContract;
use vAMSYS\Repositories\AirportsRepository;
use vAMSYS\Repositories\AirwaysRepository;
use vAMSYS\Route as RouteModel;

class Route implements RouteContract
{

  public function parse(RouteModel $route)
  {
    // Explode the route into parts
    $routeParts = explode(" ", $route->route);
    // Iterate and create sections
    $i        = 1;
    $sections = [];
    if (count($routeParts) >= 3) {
      while ($i < count($routeParts)) {
        $sections[] = [
          "from" => $routeParts[$i - 1],
          "via"  => $routeParts[$i],
          "to"   => $routeParts[$i + 1],
        ];
        $i = $i + 2;
      }
    }

    return $sections;
  }

  public function getAllPointsForRoute(RouteModel $route){
    $parsedRoute = $this->parse($route);
    $allPoints = [];
    $allPoints[] = AirportsRepository::getPointFormat($route->departureAirport);
    foreach($parsedRoute as $key => $routeSection) {
      if ($routeSection['via'] == 'DCT'){
        $allPoints = array_merge($allPoints, [
          AirwaysRepository::getPoint($routeSection['from']),
          AirwaysRepository::getPoint($routeSection['to']),
        ]);
        continue;
      }

      $sectionPoints = AirwaysRepository::getPoints($routeSection['via'], $routeSection['from'], $routeSection['to']);
      if ($key > 0){
        array_shift($sectionPoints); // Remove first waypoint as it will exist in previous iteration.
      }
      $allPoints = array_merge($allPoints, $sectionPoints);
    }
    $allPoints[] = AirportsRepository::getPointFormat($route->arrivalAirport);
    return $allPoints;
  }

}