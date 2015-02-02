<?php namespace vAMSYS;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
 * @package vAMSYS
 */
class Country extends Model {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'countries';

  public $timestamps = false;

  public function regions()
  {
    return $this->hasMany('vAMSYS\Region');
  }

}
