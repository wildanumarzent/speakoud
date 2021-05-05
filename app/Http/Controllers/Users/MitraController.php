<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\MitraRequest;
use App\Services\Instansi\InstansiMitraService;
use App\Services\Users\MitraService;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    private $service, $serviceInstansi;

    public function __construct(
        MitraService $service,
        InstansiMitraService $serviceInstansi
    )
    {
        $this->service = $service;
        $this->serviceInstansi = $serviceInstansi;
    }

    public function index(Request $request)
    {
        $url = $request->url();
        $param = str_replace($url, '', $request->fullUrl());

        $data['mitra'] = $this->service->getMitraList($request);
        $data['no'] = $data['mitra']->firstItem();
        $data['mitra']->withPath(url()->current().$param);

        return view('backend.user_management.mitra.index', compact('data'), [
            'title' => 'Mitra',
            'breadcrumbsBackend' => [
                'Mitra' => '',
            ],
        ]);
    }

    public function create()
    {
        $data['instansi'] = $this->serviceInstansi->getInstansi();

        return view('backend.user_management.mitra.form', compact('data'), [
            'title' => 'Mitra - Tambah',
            'breadcrumbsBackend' => [
                'Mitra' => route('mitra.index'),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(MitraRequest $request)
    {
        $this->service->storeMitra($request);

        return redirect()->route('mitra.index')
            ->with('success', 'User mitra berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['mitra'] = $this->service->findMitra($id);
        $data['instansi'] = $this->serviceInstansi->getInstansi();

        return view('backend.user_management.mitra.form', compact('data'), [
            'title' => 'Mitra - Edit',
            'breadcrumbsBackend' => [
                'Mitra' => route('mitra.index'),
                'Edit' => ''
            ],
        ]);
    }

    public function update(MitraRequest $request, $id)
    {
        $this->service->updateMitra($request, $id);

        return redirect()->route('mitra.index')
            ->with('success', 'User mitra berhasil diedit');
    }

    public function softDelete($id)
    {
        $delete = $this->service->softDeleteMitra($id);

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
        $this->service->deleteMitra($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
