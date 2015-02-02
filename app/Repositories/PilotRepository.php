<?php

namespace vAMSYS\Repositories;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use vAMSYS\Airline;
use vAMSYS\Booking;
use vAMSYS\Pilot;

class PilotRepository {
  public static function getCurrentPilot()
  {
    return Pilot::where('user_id', '=', Request::user()->id)
      ->where('airline_id', '=', Airline::find(Session::get('airlineId'))->id)
      ->first();
  }

  public static function countBookedFlights()
  {
    return count(Booking::where('pilot_id', '=', self::getCurrentPilot()->id)->get()->toArray());
  }
}