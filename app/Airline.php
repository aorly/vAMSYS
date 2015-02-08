<?php namespace vAMSYS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Airline
 * @package vAMSYS
 */
class Airline extends Model {

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'airlines';

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function pilots()
  {
    return $this->hasMany('vAMSYS\Pilot');
  }

  public function airports()
  {
    return $this->belongsToMany('vAMSYS\Airport');
  }

  public function aircraft()
  {
    return $this->hasMany('vAMSYS\Aircraft');
  }

  public function ranks()
  {
    return $this->hasMany('vAMSYS\Rank');
  }

}
