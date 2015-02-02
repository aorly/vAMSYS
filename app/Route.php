<?php namespace vAMSYS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Route
 * @package vAMSYS
 */
class Route extends Model {

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'routes';

  public function departureAirport()
  {
    return $this->belongsTo('vAMSYS\Airport', 'departure_id');
  }

  public function arrivalAirport()
  {
    return $this->belongsTo('vAMSYS\Airport', 'arrival_id');
  }

  public function pireps()
  {
    return $this->belongsTo('vAMSYS\Pirep');
  }

  public function airline()
  {
    return $this->hasOne('vAMSYS\Airline');
  }

  public function bookings()
  {
    return $this->belongsTo('vAMSYS\Booking');
  }

}
