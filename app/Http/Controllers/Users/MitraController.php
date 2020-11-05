<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\MitraRequest;
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
        $q = '';
        if (isset($request->q)) {
            $q = '?q='.$request->q;
        }

        $data['mitra'] = $this->service->getMitraList($request);
        $data['number'] = $data['mitra']->firstItem();
        $data['mitra']->withPath(url()->current().$q);

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

    public function destroy($id)
    {
        $this->service->deleteMitra($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
