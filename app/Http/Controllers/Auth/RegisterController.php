<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Providers\RouteServiceProvider;
use App\Services\Users\{PesertaService, InstrukturService};
use App\Services\Course\MataService;
use App\Services\Users\UserService;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    private $user, $peserta, $instruktur, $mata_pelatihan;
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
        InstrukturService $instruktur,
        MataService $mata_pelatihan
    )
    {
        $this->user = $user;
        $this->peserta = $peserta;
        $this->instruktur = $instruktur;
        $this->mata_pelatihan = $mata_pelatihan;
        $this->middleware('guest');
    }
    
    public function showRegisterForm()
    {
        return view('auth.register', [
            'title' => 'Register New Account',
            'type_pelatihan' => 'umum'
        ]);
    }
    public function showRegisterFormFree($mataId)
    {
       return view('auth.registerFree', [
            'title' => 'Register New Account',
            'mataId' => $mataId,
            'type_pelatihan' => 'free'
        ]);  
    }
      public function showRegisterPelatihan($id)
    {
         return view('auth.registerKhusus', [
            'title' => 'Register New Account',
            'mataId' => $id,
            'type_pelatihan' => 'khusus'
        ]);
    }
    public function register(RegisterRequest $request)
    {
        $encrypt = Crypt::encrypt($request->email);
     
        
        if($request->type_pelatihan =='umum'){
            $dataPeserta=$this->peserta->registerUserUmum($request);
            $data = [
            'email' => $request->email,
            'nama_peserta' => $request->name,
            'link' => route('home'),
            'link_login' => route('login'),
            'link_manage_user_request' => route('peserta.index'),
            'link_pelatihan' => route('platihan.index'),
            'link_accept_pelatihanKhusus' => null,
            'type_pelatihan' => 'UMUM'
            ];
            
            Mail::to($request->email)->send(new \App\Mail\NotifUmum($data));
            Mail::to("contact@speakoud.com")->send(new \App\Mail\ActivateAccountMailUmum($data));

            $remember = $request->has('remember') ? true : false;
           if (Auth::attempt($request->forms(), $remember)) { 
               $redirect= redirect()->route('home')->with('success', 'Register berhasil, 
               Selamat bergabung menjadi Member Speakoud, Happy Learning !!');
               return $redirect;
            }
        }

        $dataPeserta=$this->peserta->registerPeserta($request);
        if($request->type_pelatihan =='khusus')
        {
            $mataPelatihan = $this->mata_pelatihan->findMata($request->mataId);
            $data = [
                'email' => $request->email,
                'nama_peserta' => $request->name,
                'link' => route('register.activate', ['email' => $request->email]),
                'judul_pelatihan' => $mataPelatihan->judul,
                'link_login' => route('login'),
                'link_pelatihan' => route('pelatihan.detail',['id'=>$request->mataId]),
                'link_manage_user_request' => route('peserta.index'),
                'link_accept_pelatihanKhusus' =>route('peserta.detailAkses', ['id' => $dataPeserta['peserta']->id]),
                'type_pelatihan' => 'KHUSUS'
            ];
            Mail::to($request->email)->send(new \App\Mail\NotifKhusus($data));
            Mail::to("contact@speakoud.com")->send(new \App\Mail\ActivateAccountMail($data));

            $remember = $request->has('remember') ? true : false;
            if (Auth::attempt($request->forms(), $remember)) { 
                    return redirect()->route('pelatihan.detail',['id' =>$request->mataId ])->with('success', 'Registerasi berhasil, pelatihan anda sedang di tinjau,
                    Kami akan mengirimkan pemberitahuan persutujuan lewat Email anda');
            }
            
        }
        
        if($request->type_pelatihan == 'free'){
            $mataPelatihan = $this->mata_pelatihan->findMata($request->mataId);
            $data = [
            'email' => $request->email,
            'nama_peserta' => $request->name,
            'link' => route('home'), 
            'judul_pelatihan' => $mataPelatihan->judul,
            'link_login' => route('login'),
            'link_manage_user_request' => route('peserta.index'),
            'link_pelatihan' => route('pelatihan.detail',['id'=>$request->mataId]),
            'link_accept_pelatihanKhusus' =>route('peserta.detailAkses', ['id' => $dataPeserta['peserta']->id]),
            'type_pelatihan' => 'FREE'
            ];
            Mail::to($request->email)->send(new \App\Mail\Notif($data));
            Mail::to("contact@speakoud.com")->send(new \App\Mail\ActivateAccountMail($data));
            $remember = $request->has('remember') ? true : false;
           if (Auth::attempt($request->forms(), $remember)) {
                return redirect()->route('pelatihan.detail',['id' =>$request->mataId ])->with('success', 'Register berhasil, 
                Selamat bergabung menjadi Member Speakoud, Happy Learning !!');
            }
        }

        
        
    }

  
    public function activate($email)
    {
        $this->user->activateAccount($email);

        return redirect()->route('login')->with('success', 'Akun berhasil diaktivasi, 
            silahkan login');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
