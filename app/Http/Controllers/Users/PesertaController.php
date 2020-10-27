<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\PesertaRequest;
use App\Services\Users\MitraService;
use App\Services\Users\PesertaService;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    private $service, $serviceMitra;

    public function __construct(
        PesertaService $service,
        MitraService $serviceMitra
    )
    {
        $this->service = $service;
        $this->serviceMitra = $serviceMitra;
    }

    public function index(Request $request)
    {
        $q = '';
        if (isset($request->q)) {
            $q = '?q='.$request->q;
        }

        $data['peserta'] = $this->service->getPesertaList($request);
        $data['number'] = $data['peserta']->firstItem();
        $data['peserta']->withPath(url()->current().$q);

        return view('backend.user_management.peserta.index', compact('data'), [
            'title' => 'Peserta',
            'breadcrumbsBackend' => [
                'Peserta' => '',
            ],
        ]);
    }

    public function create()
    {
        $data['mitra'] = $this->serviceMitra->getMitraAll();

        return view('backend.user_management.peserta.form', compact('data'), [
            'title' => 'Peserta - Tambah',
            'breadcrumbsBackend' => [
                'Peserta' => route('peserta.index'),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(PesertaRequest $request)
    {
        $this->service->storePeserta($request);

        return redirect()->route('peserta.index')
            ->with('success', 'User peserta berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['peserta'] = $this->service->findPeserta($id);

        return view('backend.user_management.peserta.form', compact('data'), [
            'title' => 'Peserta - Edit',
            'breadcrumbsBackend' => [
                'Peserta' => route('peserta.index'),
                'Edit' => ''
            ],
        ]);
    }

    public function update(PesertaRequest $request, $id)
    {
        $this->service->updatePeserta($request, $id);

        return redirect()->route('peserta.index')
            ->with('success', 'User peserta berhasil diedit');
    }

    public function destroy($id)
    {
        $this->service->deletePeserta($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
