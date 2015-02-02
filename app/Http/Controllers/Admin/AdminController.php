<?php namespace vAMSYS\Http\Controllers\Admin;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Request;
use vAMSYS\Commands\ParseTextDataCommand;
use vAMSYS\Http\Controllers\Controller;

class AdminController extends Controller {

  /**
   * Create a new controller instance.
   */
  public function __construct()
  {
    $this->middleware('admin');
  }

  /**
   * Show the dashboard to the user.
   *
   * @return Response
   */
  public function getIndex()
  {
    return view('admin.dashboard');
  }

  public function getImport(){
    return view('admin.importTextData');
  }

  public function postImport(Guard $guard){
    $file = Request::file('textFile')->move('/tmp/vAMSYS', 'ats.txt');
    $this->dispatch(new ParseTextDataCommand([Request::get('type') => $file->getPathname()], $guard->user()->email));
    return view('admin.importTextData');
  }

}
