<?php namespace vAMSYS\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use vAMSYS\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
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

    public function postForgotPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required'
        ]);

        $email = $request->input('email');
        $user = User::where('email', '=', $email)->first();

        if (!is_null($user)){
            // Generate reset key
            $key = md5(time().$user->id.$user->email.$user->password.mt_rand());
            $user->remember_token = $key;
            $user->save();
            // Send reset email
            Mail::send('emails.forgotPassword', ['user' => $user, 'key' => $key], function ($m) use ($user) {
                $m->to($user->email, $user->name)->subject('vAMSYS Password Reset');
            });
        }

        return redirect('/auth/login')
            ->withErrors([
                'login' => 'Password Reset instructions will be sent to that email address if an account exists.',
            ]);
    }

    /**
     * @param $email
     * @param $password
     * @param bool $remember
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    protected function doEmailLogin($email, $password, $remember = false){
        if (Auth::attempt(['email' => $email, 'password' => $password], $remember))
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
