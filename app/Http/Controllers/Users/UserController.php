<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UserRequest;
use App\Services\Users\RoleService;
use App\Services\Users\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $service, $serviceRole;

    public function __construct(
        UserService $service,
        RoleService $serviceRole
    )
    {
        $this->service = $service;
        $this->serviceRole = $serviceRole;
    }

    public function index(Request $request)
    {
        $r = '';
        $a = '';
        $q = '';
        if (isset($request->r) || isset($request->a) || isset($request->q)) {
            $r = '?r='.$request->r;
            $a = '&a='.$request->a;
            $q = '&q='.$request->q;
        }

        $data['users'] = $this->service->getUserList($request);
        $data['roles'] = $this->serviceRole->getAllRole();
        $data['number'] = $data['users']->firstItem();
        $data['users']->withPath(url()->current().$r.$a.$q);

        return view('backend.user_management.users.index', compact('data'), [
            'title' => 'Users',
            'breadcrumbsBackend' => [
                'Users' => '',
            ],
        ]);
    }

    public function profileForm()
    {
        $data['user'] = auth()->user();
        $data['information'] = $data['user']->information;

        return view('backend.user_management.profile-form', compact('data'), [
            'title' => 'Profile',
            'breadcrumbsBackend' => [
                'Profile' => '',
                'Edit' => ''
            ],
        ]);
    }

    public function create()
    {
        $data['roles'] = $this->serviceRole->getRoleAdministrator(auth()->user()
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
        $data['roles'] = $this->serviceRole->getRoleAdministrator(auth()->user()
            ->roles[0]->id);

        return view('backend.user_management.users.form', compact('data'), [
            'title' => 'User - Edit',
            'breadcrumbsBackend' => [
                'Users' => route('user.index'),
                'Edit' => ''
            ],
        ]);
    }

    public function update(UserRequest $request, $id)
    {
        $this->service->updateUser($request, $id);

        return redirect()->route('user.index')
            ->with('success', 'User berhasil diedit');
    }

    public function updateProfile(ProfileRequest $request)
    {
        $this->service->updateProfile($request, auth()->user()->id);

        return back()->with('success', 'Profile updated');
    }

    public function activate($id)
    {
        $this->service->activateUser($id);

        return back()->with('success', 'User berhasil di aktivasi');
    }

    public function destroy($id)
    {
        $this->service->deleteUser($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
