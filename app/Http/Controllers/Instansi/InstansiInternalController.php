<?php

namespace App\Http\Controllers\Instansi;

use App\Http\Controllers\Controller;
use App\Http\Requests\InstansiInternalRequest;
use App\Services\Instansi\InstansiInternalService;
use Illuminate\Http\Request;

class InstansiInternalController extends Controller
{
    private $service;

    public function __construct(InstansiInternalService $service)
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

        return view('backend.instansi.internal.index', compact('data'), [
            'title' => 'Instansi Internal',
            'breadcrumbsBackend' => [
                'Instansi' => '',
                'Internal' => ''
            ],
        ]);
    }

    public function create()
    {
        return view('backend.instansi.internal.form', [
            'title' => 'Instansi Internal - Tambah',
            'breadcrumbsBackend' => [
                'Instansi' => route('instansi.internal.index'),
                'Internal' => '',
                'Tambah' => ''
            ],
        ]);
    }

    public function store(InstansiInternalRequest $request)
    {
        $this->service->storeInstansi($request);

        return redirect()->route('instansi.internal.index')
            ->with('success', 'Instansi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['instansi'] = $this->service->findInstansi($id);

        return view('backend.instansi.internal.form', compact('data'), [
            'title' => 'Instansi Internal - Ubah',
            'breadcrumbsBackend' => [
                'Instansi' => route('instansi.internal.index'),
                'Internal' => '',
                'Ubah' => ''
            ],
        ]);
    }

    public function update(InstansiInternalRequest $request, $id)
    {
        $this->service->updateInstansi($request, $id);

        return redirect()->route('instansi.internal.index')
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
                'message' => 'Data instansi masih dipakai di user bppt / instruktur bppt / peserta bppt'
            ], 200);
        }
    }
}
