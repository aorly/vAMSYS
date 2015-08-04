<?php namespace vAMSYS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnparsedLine extends Model {

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'unparsed_lines';

}
