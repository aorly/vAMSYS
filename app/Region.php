<?php namespace vAMSYS;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Region
 * @package vAMSYS
 */
class Region extends Model {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'regions';

  public $timestamps = false;

  public function airports()
  {
    return $this->hasMany('vAMSYS\Airport');
  }

  public function country()
  {
    return $this->belongsTo('vAMSYS\Country');
  }

}
