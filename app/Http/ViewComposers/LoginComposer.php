<?php namespace vAMSYS\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use League\Url\Url;
use vAMSYS\Airline;

class LoginComposer {

  /**
   * Bind data to the view.
   *
   * @param  View  $view
   * @return void
   */
  public function compose(View $view)
  {
    $url = Url::createFromServer($_SERVER);
    $airline = Airline::where('url', $url->getHost())->first();
    if ($airline)
      $view->with('airline', $airline);
  }

}