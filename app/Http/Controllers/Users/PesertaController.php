<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\PesertaRequest;
use App\Services\Instansi\InstansiInternalService;
use App\Services\Instansi\InstansiMitraService;
use App\Services\JabatanService;
use App\Services\Users\MitraService;
use App\Services\Users\PesertaService;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    private $service, $serviceMitra, $instansiInternal, $instansiMitra, $jabatanService;

    public function __construct(
        PesertaService $service,
        MitraService $serviceMitra,
        InstansiInternalService $instansiInternal,
        InstansiMitraService $instansiMitra,
        JabatanService $jabatanService
    )
    {
        $this->service = $service;
        $this->serviceMitra = $serviceMitra;
        $this->instansiInternal = $instansiInternal;
        $this->instansiMitra = $instansiMitra;
        $this->jabatanService = $jabatanService;
    }

    public function index(Request $request)
    {
        $t = '';
        $j = '';
        $q = '';
        if (isset($request->t) || isset($request->j) || isset($request->q)) {
            $t = '?t='.$request->t;
            $j = '&j='.$request->j;
            $q = '&q='.$request->q;
        }

        $data['peserta'] = $this->service->getPesertaList($request);
        $data['number'] = $data['peserta']->firstItem();
        $data['peserta']->withPath(url()->current().$t.$j.$q);

        return view('backend.user_management.peserta.index', compact('data'), [
            'title' => 'Peserta',
            'breadcrumbsBackend' => [
                'Peserta' => '',
            ],
        ]);
    }

    public function create(Request $request)
    {
        $data['mitra'] = $this->serviceMitra->getMitraAll();
        if (auth()->user()->hasRole('internal') ||
            auth()->user()->hasRole('developer|administrator') &&
            $request->get('peserta') == 'internal') {

            $data['instansi'] = $this->instansiInternal->getInstansi();

        } elseif (auth()->user()->hasRole('mitra') ||
            auth()->user()->hasRole('developer|administrator') &&
            $request->get('peserta') == 'mitra') {

            $data['instansi'] = $this->instansiMitra->getInstansi();
        }
        $data['jabatan'] = $this->jabatanService->getJabatan();

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
        if (empty($data['peserta']->mitra_id)) {
            $data['instansi'] = $this->instansiInternal->getInstansi();
        } else {
            $data['instansi'] = $this->instansiMitra->getInstansi();
        }
        $data['jabatan'] = $this->jabatanService->getJabatan();

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

    public function softDelete($id)
    {
        $delete = $this->service->softDeletePeserta($id);

        if ($delete == true) {

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);

        } else {

            return response()->json([
                'success' => 0,
                'message' => 'peserta ini sudah ter enroll di beberapa program'
            ], 200);
        }

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
