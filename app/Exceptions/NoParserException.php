<?php namespace vAMSYS\Exceptions;


class NoParserException extends \Exception {

  public function __construct($parser){
    parent::__construct($parser);
  }


}
