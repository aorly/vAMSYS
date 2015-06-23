<?php namespace vAMSYS\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider {

  public function boot()
  {
    Blade::directive('gravatar', function() {
      return '<?="http://www.gravatar.com/avatar/" . md5( strtolower( trim( $user->email ) ) ) . "?d=mm";?>';
    });

    Blade::directive('csrf', function() {
      return '<?="<input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\">";?>';
    });
  }

  public function register()
  {

  }

}