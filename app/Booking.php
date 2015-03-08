<?php namespace vAMSYS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Booking
 * @package vAMSYS
 */
class Booking extends Model {

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'bookings';

  public function pilot()
  {
    return $this->belongsTo('vAMSYS\Pilot');
  }

  public function aircraft()
  {
    return $this->belongsTo('vAMSYS\Aircraft');
  }

  public function route()
  {
    return $this->belongsTo('vAMSYS\Route');
  }

  public function pirep()
  {
      return $this->hasOne('vAMSYS\Pirep');
  }

}
