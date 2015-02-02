<?php namespace vAMSYS\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ComposerServiceProvider extends ServiceProvider {

  /**
   * Register bindings in the container.
   *
   * @param ViewFactory $view
   */
  public function boot(ViewFactory $view)
  {
    $view->composer('*', 'vAMSYS\Http\ViewComposers\GlobalComposer');
    $view->composer('flights.home', 'vAMSYS\Http\ViewComposers\FlightsComposer');
    $view->composer('flights.book', 'vAMSYS\Http\ViewComposers\FlightsBookComposer');
  }

  public function register()
  {
    //
  }

}