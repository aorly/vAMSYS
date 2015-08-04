<?php namespace vAMSYS\Http\Controllers\Admin;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Request;
use vAMSYS\Commands\ParseTextDataCommand;
use vAMSYS\Http\Controllers\Controller;
use vAMSYS\UnparsedLine;

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
  public function getIndex(){
    return view('admin.dashboard');
  }

  public function getUnparsedLines(){
    return view('admin.unparsedLines', ['lines' => UnparsedLine::all()]);
  }

  public function getDeleteUnparsedLine(UnparsedLine $line){
    $line->delete();
    return redirect('/admin/unparsed-lines');
  }

}
