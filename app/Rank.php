<?php namespace vAMSYS;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model {

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'ranks';

  public function airline()
  {
    return $this->belongsTo('vAMSYS\Airline');
  }

  public function pilots()
  {
    return $this->hasMany('vAMSYS\Pilot');
  }

  public function aircraft()
  {
    return $this->hasMany('vAMSYS\Aircraft');
  }

}
