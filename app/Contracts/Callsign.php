<?php namespace vAMSYS\Contracts;

interface Callsign
{
  public function generate($prefix, $rules);
}