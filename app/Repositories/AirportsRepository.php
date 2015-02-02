<?php

namespace vAMSYS\Repositories;

use vAMSYS\Airport;

class AirportsRepository {
  public static function getPointFormat(Airport $airport){
    return (object)[
      "name"      => $airport->name,
      "latitude"  => $airport->latitude,
      "longitude" => $airport->longitude,
    ];
  }
}