<?php

namespace vAMSYS\Services;

use vAMSYS\SmartCARS_Session;

class SmartCARS implements \vAMSYS\Contracts\SmartCARS
{

  public function clearOldSessions()
  {
    $timestamp = time() - 2592000;
    SmartCARS_Session::where('timestamp', '<', $timestamp)->delete();
  }

  public function writeSessionId($pilotId, $sessionId)
  {
    $session = new SmartCARS_Session();
    $session->dbid = $pilotId;
    $session->sessionid = $sessionId;
    $session->timestamp = time();
    $session->save();
  }

  public function sanitizeResult($result)
  {
    return str_replace(",","",$result);
  }

}