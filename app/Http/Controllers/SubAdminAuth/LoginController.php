<?php

namespace App\Http\Controllers\SubAdminAuth;

use App\Models\Subadmin;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

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


    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/provider/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:subadmin', ['except' => ['logout']]);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('subadmin.auth.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('subadmin');
    }

    public function login(Request $request)
    {

        $field = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([$field => $request->input('email')]);

        $item = Subadmin::where('email', $request->email)->first();
        if (!$item) {
            return redirect('/provider/login')->withErrors([
                'error' => getLocal() == 'en' ? 'These credentials do not match our records.' : 'خطأ في البريد الالكتروني أو كلمة المرور',
            ])->withInput($request->only('email', 'remember'));
        }

        if ($item->status == 'not_active') {
            return redirect('/provider/login')->withErrors([
                'error' => getLocal() == 'en' ? 'Your Account Not Active' : 'الحساب غير مفعل',
            ])->withInput($request->only('email', 'remember'));
        }
        if (Auth::guard('subadmin')->attempt($request->only('email', 'password'))) {
            return redirect('/provider/home');
        } else {

            return redirect('/provider/login')->withErrors([
                'error' => getLocal() == 'en' ? 'These credentials do .' : 'خطأ في البريد الالكتروني أو كلمة المرور',
            ])->withInput($request->only('email', 'remember'));
        }
    }


    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::guard('subadmin')->logout();

        return redirect('/provider/login');
    }


}
