<?php

namespace App\Http\Controllers\Instansi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Instansi\InstansiMitraRequest;
use App\Services\Instansi\InstansiMitraService;
use Illuminate\Http\Request;

class InstansiMitraController extends Controller
{
    private $service;

    public function __construct(
        InstansiMitraService $service
    )
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $url = $request->url();
        $param = str_replace($url, '', $request->fullUrl());

        $data['instansi'] = $this->service->getInstansiList($request);
        $data['no'] = $data['instansi']->firstItem();
        $data['instansi']->withPath(url()->current().$param);

        return view('backend.instansi.mitra.index', compact('data'), [
            'title' => 'Instansi Mitra',
            'breadcrumbsBackend' => [
                'Instansi' => '#!',
                'Mitra' => ''
            ],
        ]);
    }

    public function create()
    {
        return view('backend.instansi.mitra.form', [
            'title' => 'Instansi Mitra - Tambah',
            'breadcrumbsBackend' => [
                'Instansi' => '#!',
                'Mitra' => route('instansi.mitra.index'),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(InstansiMitraRequest $request)
    {
        $this->service->storeInstansi($request);

        return redirect()->route('instansi.mitra.index')
            ->with('success', 'Instansi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['instansi'] = $this->service->findInstansi($id);

        return view('backend.instansi.mitra.form', compact('data'), [
            'title' => 'Instansi Mitra - Ubah',
            'breadcrumbsBackend' => [
                'Instansi' => '#!',
                'Mitra' => route('instansi.mitra.index'),
                'Ubah' => ''
            ],
        ]);
    }

    public function update(InstansiMitraRequest $request, $id)
    {
        $this->service->updateInstansi($request, $id);

        return redirect()->route('instansi.mitra.index')
            ->with('success', 'Instansi berhasil diubah');
    }

    public function destroy($id)
    {
        $delete = $this->service->deleteInstansi($id);

        if ($delete == true) {

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);

        } else {

            return response()->json([
                'success' => 0,
                'message' => 'Data instansi masih digunakan oleh user mitra / instruktur mitra / peserta mitra'
            ], 200);

        }
    }
}
