<?php namespace vAMSYS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Airport
 * @package vAMSYS
 */
class Airport extends Model {

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'airports';

  public function departureRoutes()
  {
    return $this->hasMany('vAMSYS\Route', 'departure_id');
  }

  public function arrivalRoutes()
  {
    return $this->hasMany('vAMSYS\Route', 'arrival_id');
  }

  public function airlines()
  {
    return $this->belongsToMany('vAMSYS\Airline');
  }

  public function region()
  {
    return $this->belongsTo('vAMSYS\Region');
  }

}
