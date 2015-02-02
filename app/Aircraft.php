<?php namespace vAMSYS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Aircraft
 * @package vAMSYS
 */
class Aircraft extends Model {

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'aircraft';

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function airline()
  {
    return $this->belongsTo('vAMSYS\Airline');
  }

}
