<?php

namespace vAMSYS\Repositories;

use vAMSYS\Airport;
use vAMSYS\Route;

class RoutesRepository {
  public static function getRoutesFrom(Airport $airport)
  {
    // Get all outbound routes from this airport
    return Route::where('departure_id', '=', $airport->id)
      ->where('airline_id', '=', PilotRepository::getCurrentPilot()->airline->id)
      ->get();
  }

}