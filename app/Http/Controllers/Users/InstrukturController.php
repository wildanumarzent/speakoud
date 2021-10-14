<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\InstrukturRequest;
use App\Services\Instansi\InstansiInternalService;
use App\Services\Instansi\InstansiMitraService;
use App\Services\Users\InstrukturService;
use App\Services\Users\MitraService;
use App\Services\Users\PesertaService;
use Illuminate\Http\Request;

class InstrukturController extends Controller
{
    private $service, $serviceMitra, $instansiInternal, $instansiMitra, $pesertaService;

    public function __construct(
        InstrukturService $service,
        MitraService $serviceMitra,
        InstansiInternalService $instansiInternal,
        InstansiMitraService $instansiMitra,
        PesertaService $pesertaService
    )
    {
        $this->service = $service;
        $this->serviceMitra = $serviceMitra;
        $this->instansiInternal = $instansiInternal;
        $this->instansiMitra = $instansiMitra;
        $this->pesertaService = $pesertaService;
    }

    public function index(Request $request)
    {
        $url = $request->url();
        $param = str_replace($url, '', $request->fullUrl());

        $data['instruktur'] = $this->service->getInstrukturList($request);
        $data['no'] = $data['instruktur']->firstItem();
        $data['instruktur']->withPath(url()->current().$param);

        return view('backend.user_management.instruktur.index', compact('data'), [
            'title' => 'Instruktur',
            'breadcrumbsBackend' => [
                'Instruktur' => '',
            ],
        ]);
    }

    public function create(Request $request)
    {
        $data['mitra'] = $this->serviceMitra->getMitraAll();

        if (auth()->user()->hasRole('internal') ||
            auth()->user()->hasRole('developer|administrator') &&
            $request->get('instruktur') == 'internal') {

            $data['instansi'] = $this->instansiInternal->getInstansi();

        } elseif (auth()->user()->hasRole('mitra') ||
            auth()->user()->hasRole('developer|administrator') &&
            $request->get('instruktur') == 'mitra') {

            $data['instansi'] = $this->instansiMitra->getInstansi();
        }
        $data['peserta'] = $this->pesertaService->findPesertaByUserId($request->id);
        return view('backend.user_management.instruktur.form', compact('data'), [
            'title' => 'Instruktur - Tambah',
            'breadcrumbsBackend' => [
                'Instruktur' => route('instruktur.index'),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(InstrukturRequest $request)
    {
        // return $request->all();
        $this->service->storeInstruktur($request);

        return redirect()->route('instruktur.index')
            ->with('success', 'User instruktur berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['instruktur'] = $this->service->findInstruktur($id);
        $data['peserta'] = $this->pesertaService->findPesertaByUserId($id);
        if (empty($data['instruktur']->mitra_id)) {
            $data['instansi'] = $this->instansiInternal->getInstansi();
        } else {
            $data['instansi'] = $this->instansiMitra->getInstansi();
        }

        return view('backend.user_management.instruktur.form', compact('data'), [
            'title' => 'Instruktur - Edit',
            'breadcrumbsBackend' => [
                'Instruktur' => route('instruktur.index'),
                'Edit' => ''
            ],
        ]);
    }

    public function update(InstrukturRequest $request, $id)
    {
        $this->service->updateInstruktur($request, $id);

        return redirect()->route('instruktur.index')
            ->with('success', 'User instruktur berhasil diedit');
    }

    public function softDelete($id)
    {
        $delete = $this->service->softDeleteInstruktur($id);

        if ($delete == true) {

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);

        } else {
            
            return response()->json([
                'success' => 0,
                'message' => 'Instruktur ini sudah ter enroll di beberapa program'
            ], 200);
        }
        
    }

    public function destroy($id)
    {
        $this->service->deleteInstruktur($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
