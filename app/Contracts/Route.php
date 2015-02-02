<?php namespace vAMSYS\Contracts;

interface Route
{
  public function parse(\vAMSYS\Route $route);

  public function getAllPointsForRoute(\vAMSYS\Route $route);
}