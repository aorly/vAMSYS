<?php namespace vAMSYS;

use Illuminate\Database\Eloquent\Model;

class PositionReport extends Model {

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'position_reports';

  public function booking()
  {
    return $this->belongsTo('vAMSYS\Booking');
  }

}
