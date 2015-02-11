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

  public function booking()
  {
    return $this->belongsTo('vAMSYS\Booking');
  }

  public function positionReports()
  {
    return $this->hasManyThrough('vAMSYS\PositionReport', 'vAMSYS\Booking');
  }

}
