<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ProfileRequest;
use App\Http\Requests\User\UserRequest;
use App\Services\JabatanService;
use App\Services\LearningCompetency\JourneyService;
use App\Services\Users\RoleService;
use App\Services\Users\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    private $service, $serviceRole, $serviceJabatan;

    public function __construct(
        UserService $service,
        RoleService $serviceRole,
        JourneyService $journey,
        JabatanService $serviceJabatan
    )
    {
        $this->service = $service;
        $this->serviceRole = $serviceRole;
        $this->journey = $journey;
        $this->serviceJabatan = $serviceJabatan;
    }

    public function index(Request $request)
    {
    //   return "test";
        $url = $request->url();
        $param = str_replace($url, '', $request->fullUrl());

        $data['users'] = $this->service->getUserList($request, false);
        $data['roles'] = $this->serviceRole->getAllRole();
        $data['no'] = $data['users']->firstItem();
        $data['users']->withPath(url()->current().$param);
        
        return view('backend.user_management.users.index', compact('data'), [
            'title' => 'Users',
            'breadcrumbsBackend' => [
                'Users' => '',
            ],
        ]);
    }

    public function trash(Request $request)
    {
        $url = $request->url();
        $param = str_replace($url, '', $request->fullUrl());

        $data['users'] = $this->service->getUserList($request, true);
        $data['roles'] = $this->serviceRole->getAllRole();
        $data['no'] = $data['users']->firstItem();
        $data['users']->withPath(url()->current().$param);

        return view('backend.user_management.users.trash', compact('data'), [
            'title' => 'Users - Tong Sampan',
            'breadcrumbsBackend' => [
                'Users' => route('user.index'),
                'Tong Sampah' => ''
            ],
        ]);
    }

    public function profile()
    {
        $data['user'] = Auth::user();
        $data['information'] = $data['user']->information;
        
        if (Auth::user()->hasRole('peserta_internal|peserta_mitra')) {
            $data['myJourney'] = $this->journey->myJourney(Auth::user()->peserta->id);
        }

        return view('backend.user_management.profile', compact('data'), [
            'title' => 'Profile',
            'breadcrumbsFrontend' => [
                'Profile' => '',
            ],
        ]);
    }

    public function profileForm()
    {
        $data['user'] = Auth::user();
        $data['information'] = $data['user']->peserta;
        $data['jabatan'] = $this->serviceJabatan->getJabatan();

        return view('backend.user_management.profile-form', compact('data'), [
            'title' => 'Profile - Ubah',
            'breadcrumbsBackend' => [
                'Profile' => '#!',
                'Ubah' => ''
            ],
        ]);
    }

    public function profileFront($id)
    {
        $data['user'] = Auth::user();
        $data['information'] = $data['user']->peserta;
        $data['jabatan'] = $this->serviceJabatan->getJabatan();
        $data['id'] = $id;
        
        $this->service->setMataPeserta($data['id'], $data['information']->id);


        return view('frontend.pelatihan.profile-form', compact('data'), [
            'title' => 'Profile - Ubah',
            // 'breadcrumbsBackend' => [
            //     'Profile' => '#!',
            //     'Ubah' => ''
            // ],
        ]);
    }
    public function create()
    {
        $data['roles'] = $this->serviceRole->getRoleAdministrator(Auth::user()
            ->roles[0]->id);

        return view('backend.user_management.users.form', compact('data'), [
            'title' => 'User - Tambah',
            'breadcrumbsBackend' => [
                'Users' => route('user.index'),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(UserRequest $request)
    {
        $this->service->storeUser($request);

        return redirect()->route('user.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['user'] = $this->service->findUser($id);
        $data['roles'] = $this->serviceRole->getRoleAdministrator(Auth::user()
            ->roles[0]->id);

        return view('backend.user_management.users.form', compact('data'), [
            'title' => 'User - Ubah',
            'breadcrumbsBackend' => [
                'Users' => route('user.index'),
                'Ubah' => ''
            ],
        ]);
    }

    public function update(UserRequest $request, $id)
    {
        $this->service->updateUser($request, $id);

        return redirect()->route('user.index')
            ->with('success', 'User berhasil diubah');
    }

    public function updateProfile(ProfileRequest $request)
    {
        // return $request->all();
        $this->service->updateProfile($request, Auth::user()->id);
        return back()->with('success', 'Profile berhasil diubah');
    }

    public function updateProfileFront(ProfileRequest $request, $id)
    {
        $this->service->updateProfileFront($request, Auth::user()->id);
        return redirect()->route('pelatihan.mata',['id' => $id])
            ->with('success', 'Data User Berhasil Di Update');
    }

    public function activate($id)
    {
        $this->service->activateUser($id);

        return back()->with('success', 'User berhasil di aktivasi');
    }

    public function sendVerification()
    {
        $encrypt = Crypt::encrypt(Auth::user()->email);

        $data = [
            'email' => Auth::user()->email,
            'link' => route('profile.email.verification', ['email' => $encrypt]),
        ];

        // Mail::to(Auth::user()->email)->send(new \App\Mail\VerificationMail($data));

        return back()->with('success', 'Berhasil mengirim link. Cek email untuk verifikasi email');
    }

    public function verification($email)
    {
        $this->service->verificationEmail($email);
        return redirect()->route('profile')->with('success', 'Email berhasil diverifikasi');
    }

    public function softDelete($id)
    {
        $delete = $this->service->softDeleteUser($id);

        if ($delete == true) {

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);

        } else {

            return response()->json([
                'success' => 0,
                'message' => 'User tidak bisa dihapus, dikarenakan masih memiliki data yang bersangkutan'
            ], 200);
        }
    }

    public function restore($id)
    {
        $this->service->restoreUser($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }

    public function destroy($id)
    {
        // $delete = $this->service->deleteUser($id);

        // if ($delete == true) {

        //     return response()->json([
        //         'success' => 1,
        //         'message' => ''
        //     ], 200);

        // } else {

        //     return response()->json([
        //         'success' => 0,
        //         'message' => 'User tidak bisa dihapus, dikarenakan masih memiliki data yang bersangkutan'
        //     ], 200);
        // }

        try {
            
            $this->service->deleteUser($id);

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);

        } catch (\Throwable $th) {
            //throw $th;

            return response()->json([
                'success' => 0,
                'message' => $th->getMessage(),
            ], 200);
        }

    }
}
