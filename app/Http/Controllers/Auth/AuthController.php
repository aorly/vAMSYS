<?php namespace vAMSYS\Http\Controllers\Auth;

use Illuminate\Http\Request;
use vAMSYS\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use vAMSYS\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use vAMSYS\Pilot;

/**
 * Class AuthController
 * @package vAMSYS\Http\Controllers\Auth
 */
class AuthController extends Controller {

	use AuthenticatesAndRegistersUsers;

	/**
	 * @var
	 */
	protected $redirectTo;

	public function __construct()
	{
		$this->middleware('guest', ['except' => ['getLogout']]);
	}

	/**
	 * @param Request $request
	 * @return $this
	 */
	public function postLogin(Request $request)
	{
		$this->validate($request, [
			'login' => 'required', 'password' => 'required',
		]);

		$login = $request->input('login');

		if (!filter_var($login, FILTER_VALIDATE_EMAIL)){
			// It's not an email address - try and find the user from our Pilots!
			if ($pilot = Pilot::where('username', '=', $login)->first()){
				// Login with this user's email address!
				$login = $pilot->user->email;
				Session::put('airlineId', $pilot->airline->id);
				return $this->doEmailLogin($login, $request->input('password'), $request->has('remember'));
			} else {
				return $this->loginError($login);
			}
		}

		// We have an email address -> this is not supported!
		return $this->loginError($login);
	}

	/**
	 * @param $email
	 * @param $password
	 * @param bool $remember
	 * @return $this|\Illuminate\Http\RedirectResponse
   */
	protected function doEmailLogin($email, $password, $remember = false){
		if ($this->auth->attempt(['email' => $email, 'password' => $password], $remember))
		{
			return redirect('/');
		}

		// Could not login with this email
		return $this->loginError($email);
	}

	/**
	 * @param $login
	 * @return $this
	 */
	protected function loginError($login){
		return redirect('/auth/login')
			->withInput(['login' => $login])
			->withErrors([
				'login' => 'Invalid Credentials',
			]);
	}

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  public function validator(array $data)
  {
    return Validator::make($data, [
      'first_name' => 'required|max:255',
      'last_name' => 'required|max:255',
      'email' => 'required|email|max:255|unique:users',
      'password' => 'required',
    ]);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return User
   */
  public function create(array $data)
  {
    return User::create([
      'first_name' => $data['first_name'],
      'last_name' => $data['last_name'],
      'email' => $data['email'],
      'password' => bcrypt($data['password']),
    ]);
  }

}
