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
    $routeParts = explode(" ", ltrim(rtrim($route->route)));
    // Iterate and create sections
    $i        = 1;
    $sections = [];
    if (count($routeParts) >= 3) {
      while ($i < count($routeParts)) {
        // Check for co-ordinates
        $coordinateRegex = '/(((\d{1,3})(N|S))((\d{1,3})(E|W)))/';
        if (preg_match($coordinateRegex, $routeParts[$i - 1]) && preg_match($coordinateRegex, $routeParts[$i])){
          $sections[] = [
              "from" => $routeParts[$i - 1],
              "via"  => 'DCT',
              "to"   => $routeParts[$i],
          ];
          $i = $i + 1;
          continue;
        }

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
      if (AirwaysRepository::getPoint($routeSection['from']) === null || AirwaysRepository::getPoint($routeSection['to'], $routeSection['from']) === null)
        continue;

      if ($routeSection['via'] == 'DCT'){
        $allPoints = array_merge($allPoints, [
          AirwaysRepository::getPoint($routeSection['from']),
          AirwaysRepository::getPoint($routeSection['to'], $routeSection['from']),
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