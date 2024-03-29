<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;

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
        try {

            $remember = $request->has('remember') ? true : false;
            if (auth()->attempt($request->forms(), $remember)) {

                if (auth()->user()->hasRole('super|administrator|internal|mitra')) {
                    $redirect = redirect()->route('dashboard');
                } else {
                    $redirect = redirect()->route('home');
                }

                return $redirect->with('success', 'Login berhasil');
            } else {
                return back()->with('failed', 'Username / Password salah !');
            }

         } catch (\Throwable $th) {
             //throw $th;
             return back()->with('failed', $th->getMessage());
         }
    }

    public function logout()
    {
       try {

           auth()->logout();

           return redirect()->route('login')
                ->with('success', 'Logout berhasil');
       } catch (\Throwable $th) {
           //throw $th;
           return back()->with('failed', $th->getMessage());
       }
    }
}
