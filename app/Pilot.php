<?php namespace vAMSYS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Pilot
 * @package vAMSYS
 */
class Pilot extends Model {

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'pilots';

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo('vAMSYS\User');
  }

  public function airline()
  {
    return $this->belongsTo('vAMSYS\Airline');
  }

  public function location()
  {
    return $this->belongsTo('vAMSYS\Airport', 'location_id');
  }

  public function pireps()
  {
    return $this->hasMany('vAMSYS\Pirep');
  }

  public function rank()
  {
    return $this->belongsTo('vAMSYS\Rank');
  }

  public function bookings()
  {
    return $this->hasMany('vAMSYS\Booking');
  }

}
