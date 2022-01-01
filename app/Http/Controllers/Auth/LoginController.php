<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Auth;
use Session;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        logout as performLogout;
    }

    public function logout(Request $request)
    {
        $this->performLogout($request);
        return redirect()->route('login');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $auth;
    protected $redirectTo = RouteServiceProvider::DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('web')->except('logout');
    }

    protected function credentials(Request $request) {
        return array_merge($request->only($this->username(), 'password'), ['is_active' => 1]);
    }

    public function login(Request $request)
    {
        $errors = [$this->username() => 'Your account is not activated. Please contact your admin.'];

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            if ($user->is_active == 0) {
                Auth::logout();
                return redirect()->back()->withInput($request->only($this->username(), 'remember'))->withErrors($errors);
            }

            return redirect()->intended('dashboard');
        }
        else{
            return $this->sendFailedLoginResponse($request);
        }
    }
}
