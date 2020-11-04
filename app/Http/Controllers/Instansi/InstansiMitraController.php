<?php

namespace App\Http\Controllers\Instansi;

use App\Http\Controllers\Controller;
use App\Http\Requests\InstansiMitraRequest;
use App\Services\Instansi\InstansiMitraService;
use Illuminate\Http\Request;

class InstansiMitraController extends Controller
{
    private $service;

    public function __construct(InstansiMitraService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $q = '';
        if (isset($request->q)) {
            $q = '?q='.$request->q;
        }

        $data['instansi'] = $this->service->getInstansiList($request);
        $data['number'] = $data['instansi']->firstItem();
        $data['instansi']->withPath(url()->current().$q);

        return view('backend.instansi.mitra.index', compact('data'), [
            'title' => 'Instansi Mitra',
            'breadcrumbsBackend' => [
                'Instansi' => '',
                'Mitra' => ''
            ],
        ]);
    }

    public function create()
    {
        return view('backend.instansi.mitra.form', [
            'title' => 'Instansi Mitra - Tambah',
            'breadcrumbsBackend' => [
                'Instansi' => route('instansi.mitra.index'),
                'Mitra' => '',
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
            'title' => 'Instansi Mitra - Edit',
            'breadcrumbsBackend' => [
                'Instansi' => route('instansi.mitra.index'),
                'Mitra' => '',
                'Edit' => ''
            ],
        ]);
    }

    public function update(InstansiMitraRequest $request, $id)
    {
        $this->service->updateInstansi($request, $id);

        return redirect()->route('instansi.mitra.index')
            ->with('success', 'Instansi berhasil diedit');
    }

    public function destroy($id)
    {
        $this->service->deleteInstansi($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
