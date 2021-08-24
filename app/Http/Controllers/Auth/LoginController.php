<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;

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

    use AuthenticatesUsers, ValidatesRequests;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login', [
            'title' => 'Login to the site',
        ]);
    }

    public function login(LoginRequest $request)
    {
        // return $request->forms();
        try {

            $remember = $request->has('remember') ? true : false;
            if (Auth::attempt($request->forms(), $remember)) {
                
                $redirect = redirect()->route('dashboard');

                return $redirect->with('success', 'Login berhasil');
            } else {
                return back()->with('failed', 'Email / Password salah !');
            }

         } catch (\Throwable $th) {
             //throw $th;
             return back()->with('failed', $th->getMessage());
         }
    }

    public function logout()
    {
       try {

           Auth::logout();

           return redirect()->route('login')->with('success', 'Logout berhasil');
       } catch (\Throwable $th) {
           //throw $th;
           return back()->with('failed', $th->getMessage());
       }
    }
}
