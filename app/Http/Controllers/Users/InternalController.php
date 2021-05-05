<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\InternalRequest;
use App\Services\Instansi\InstansiInternalService;
use App\Services\Users\InternalService;
use Illuminate\Http\Request;

class InternalController extends Controller
{
    private $service, $serviceInstansi;

    public function __construct(
        InternalService $service,
        InstansiInternalService $serviceInstansi
    )
    {
        $this->service = $service;
        $this->serviceInstansi = $serviceInstansi;
    }

    public function index(Request $request)
    {
        $url = $request->url();
        $param = str_replace($url, '', $request->fullUrl());

        $data['internal'] = $this->service->getInternalList($request);
        $data['no'] = $data['internal']->firstItem();
        $data['internal']->withPath(url()->current().$param);

        return view('backend.user_management.internal.index', compact('data'), [
            'title' => 'User BPPT',
            'breadcrumbsBackend' => [
                'User' => route('user.index'),
                'BPPT' => ''
            ],
        ]);
    }

    public function create()
    {
        $data['instansi'] = $this->serviceInstansi->getInstansi();

        return view('backend.user_management.internal.form', compact('data'), [
            'title' => 'User BPPT - Tambah',
            'breadcrumbsBackend' => [
                'User' => route('user.index'),
                'BPPT' => route('internal.index'),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(InternalRequest $request)
    {
        $this->service->storeInternal($request);

        return redirect()->route('internal.index')
            ->with('success', 'User internal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['internal'] = $this->service->findInternal($id);
        $data['instansi'] = $this->serviceInstansi->getInstansi();

        return view('backend.user_management.internal.form', compact('data'), [
            'title' => 'User BPPT - Edit',
            'breadcrumbsBackend' => [
                'User' => route('user.index'),
                'BPPT' => route('internal.index'),
                'Edit' => ''
            ],
        ]);
    }

    public function update(InternalRequest $request, $id)
    {
        $this->service->updateInternal($request, $id);

        return redirect()->route('internal.index')
            ->with('success', 'User internal berhasil diubah');
    }

    public function softDelete($id)
    {
        $delete = $this->service->softDeleteInternal($id);

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

    public function destroy($id)
    {
        $this->service->deleteInternal($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
