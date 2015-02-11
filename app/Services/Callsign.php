<?php namespace vAMSYS\Services;

use Hoa\Compiler\Llk\Llk;
use Hoa\File\Read;
use Hoa\Math\Sampler\Random;
use Hoa\Regex\Visitor\Isotropic;
use vAMSYS\Contracts\Callsign as CallsignContract;

/**
 * Class Callsign
 * @package vAMSYS\Services
 */
class Callsign implements CallsignContract
{
  /**
   * @param $prefix
   * @param $rules
   * @return mixed
   * @throws \Hoa\Compiler\Exception
   * @throws \Hoa\Regex\Exception
   */
  public function generate($prefix, $rules)
  {
    $grammar     = new Read('hoa://Library/Regex/Grammar.pp');
    $compiler    = Llk::load($grammar);
    $ast         = $compiler->parse($prefix.$rules);
    $generator   = new Isotropic(new Random());
    return $generator->visit($ast);

  }
}