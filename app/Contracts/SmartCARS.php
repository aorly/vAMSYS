<?php namespace vAMSYS\Contracts;

interface SmartCARS
{
  public function clearOldSessions();

  public function writeSessionId($pilotId, $sessionId);

  public function sanitizeResult($result);
}