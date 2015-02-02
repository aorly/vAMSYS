<?php namespace vAMSYS\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider {

  public function register()
  {
    // Blade Templating Extensions
    Blade::extend(function($view, $compiler)
    {
      $pattern = $compiler->createPlainMatcher('gravatar');
      return preg_replace($pattern, '<?="http://www.gravatar.com/avatar/" . md5( strtolower( trim( $user->email ) ) ) . "?d=mm";?>', $view);
    });

    Blade::extend(function($view, $compiler)
    {
      $pattern = $compiler->createPlainMatcher('csrf');
      return preg_replace($pattern, '<?="<input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\">";?>', $view);
    });


  }

}