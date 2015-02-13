<?php namespace vAMSYS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Contracts\Billable as BillableContract;

/**
 * Class Airline
 * @package vAMSYS
 */
class Airline extends Model implements BillableContract {

  use Billable, SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'airlines';

  protected $dates = ['trial_ends_at', 'subscription_ends_at'];

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

  public function routes()
  {
    return $this->hasMany('vAMSYS\Route');
  }

  public function pireps()
  {
    return $this->hasManyThrough('vAMSYS\Pirep', 'vAMSYS\Pilot');
  }

}
