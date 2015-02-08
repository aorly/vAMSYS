<?php namespace vAMSYS;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SmartCARS_Session
 * @package vAMSYS
 */
class SmartCARS_Session extends Model {

  protected $table = 'smartCARS_sessions';

  public function pilot()
  {
    $this->belongsTo('vAMSYS\Pilot');
  }

}
