<?php namespace vAMSYS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pirep extends Model {

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'pireps';

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

}
