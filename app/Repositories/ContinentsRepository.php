<?php

namespace vAMSYS\Repositories;

use vAMSYS\Airport;

class ContinentsRepository {
  public static function getRegions($continentString){
    $regions = Region::where('continent', '=', $continentString)->get();
    return $regions;
  }
}