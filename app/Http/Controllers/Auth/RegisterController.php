<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Providers\RouteServiceProvider;
use App\Services\Users\{PesertaService, InstrukturService};
use App\Services\Users\UserService;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    private $user, $peserta, $instruktur;
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        UserService $user, 
        PesertaService $peserta,
        InstrukturService $instruktur
    )
    {
        $this->user = $user;
        $this->peserta = $peserta;
        $this->instruktur = $instruktur;

        $this->middleware('guest');
    }

    public function showRegisterForm()
    {
        return view('auth.register', [
            'title' => 'Register New Account'
        ]);
    }

      public function showRegisterPelatihan($id)
    {
         return view('auth.registerKhusus', [
            'title' => 'Register New Account',
            'mataId' => $id
        ]);
    }
    public function register(RegisterRequest $request)
    {
        
  
        $encrypt = Crypt::encrypt($request->email);
        $dataPeserta=$this->peserta->registerPeserta($request);
        if($request->mataId != 0 && $request->mataId != null)
        {
            $data = [
                'email' => $request->email,
                'nama_peserta' => $request->name,
                'link' => route('register.activate', ['email' => $request->email]),
                'link_login' => route('login'),
                'link_pelatihan' => route('pelatihan.detail',['id'=>$request->mataId]),
                'link_manage_user_request' => route('peserta.index'),
                'link_accept_pelatihanKhusus' =>route('peserta.detailAkses', ['id' => $dataPeserta['peserta']->id]),
            ];
            Mail::to($request->email)->send(new \App\Mail\NotifKhusus($data));
            Mail::to("contact@speakoud.com")->send(new \App\Mail\ActivateAccountMail($data));

            $remember = $request->has('remember') ? true : false;
            if (Auth::attempt($request->forms(), $remember)) { 
                    return redirect()->route('pelatihan.detail',['id' =>$request->mataId ])->with('success', 'Register berhasil, 
                    silahkan cek email untuk aktivasi & verifikasi akun');
            }else{
                $data = [
                'email' => $request->email,
                'name' => $request->name,
                'link' => route('home'),    
                ];
                Mail::to($request->email)->send(new \App\Mail\Notif($data));
            //  Mail::to("contact@speakoud.com")->s◘end(new \App\Mail\ActivateAccountMail($data));
               
             }
            
        }
            $remember = $request->has('remember') ? true : false;
            if (Auth::attempt($request->forms(), $remember)) { 
            
                return redirect()->route('home')->with('success', 'Register berhasil, 
                silahkan cek email untuk aktivasi & verifikasi akun');
            }
        
    }

  
    // public function activate($email)
    // {
    //     $this->user->activateAccount($email);

    //     return redirect()->route('login')->with('success', 'Akun berhasil diaktivasi, 
    //         silahkan login');
    // }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //     ]);
    // }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    // protected function create(array $data)
    // {
    //     return User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'password' => Hash::make($data['password']),
    //     ]);
    // }
}
