<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\JabatanRequest;
use App\Services\JabatanService;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    private $service;

    public function __construct(JabatanService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $q = '';
        if (isset($request->q)) {
            $q = '?q='.$request->q;
        }

        $data['jabatan'] = $this->service->getJabatanList($request);
        $data['number'] = $data['jabatan']->firstItem();
        $data['jabatan']->withPath(url()->current().$q);

        return view('backend.jabatan.index', compact('data'), [
            'title' => 'Jabatan',
            'breadcrumbsBackend' => [
                'Jabatan' => ''
            ],
        ]);
    }

    public function create()
    {
        return view('backend.jabatan.form', [
            'title' => ' Jabatan - Tambah',
            'breadcrumbsBackend' => [
                'Jabatan' => route('jabatan.index'),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(JabatanRequest $request)
    {
        $this->service->storeJabatan($request);

        return redirect()->route('jabatan.index')
            ->with('success', 'Jabatan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['jabatan'] = $this->service->findJabatan($id);

        return view('backend.jabatan.form', compact('data'), [
            'title' => 'Jabatan - Edit',
            'breadcrumbsBackend' => [
                'Jabatan' => route('jabatan.index'),
                'Edit' => ''
            ],
        ]);
    }

    public function update(JabatanRequest $request, $id)
    {
        $this->service->updateJabatan($request, $id);

        return redirect()->route('jabatan.index')
            ->with('success', 'Jabatan berhasil diedit');
    }

    public function destroy($id)
    {
        $delete = $this->service->deleteJabatan($id);

        if ($delete == true) {

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);

        } else {

            return response()->json([
                'success' => 0,
                'message' => 'Jabatan ini masih dipakai user bersangkutan'
            ], 200);
        }
    }
}
