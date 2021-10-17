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
use Illuminate\Support\Facades\Mail;
use App\Services\Course\MataService;

class InstrukturController extends Controller
{
    private $service, $serviceMitra, $instansiInternal, $instansiMitra, $pesertaService, $pelatihan;

    public function __construct(
        InstrukturService $service,
        MitraService $serviceMitra,
        InstansiInternalService $instansiInternal,
        InstansiMitraService $instansiMitra,
        PesertaService $pesertaService,
        MataService $pelatihan
    )
    {
        $this->service = $service;
        $this->serviceMitra = $serviceMitra;
        $this->instansiInternal = $instansiInternal;
        $this->instansiMitra = $instansiMitra;
        $this->pesertaService = $pesertaService;
        $this->pelatihan = $pelatihan;
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

    public function mintaAkses_pelatihan($mataId, $instrukturId)
    {
        $data= $this->service->MintaAkses($mataId,$instrukturId);
        $pelatihan =$this->pelatihan->findMata($mataId);
        $data = [
            'email' => auth()->user()->email, 
            'judul_pelatihan' => $pelatihan->judul,
            'nama_peserta' => auth()->user()->name,
            'link_speakoud' => route('home'),
            'link_login' => route('login'),
            'link_manage_user_request' => route('peserta.index'),
            'link_pelatihan' => route('pelatihan.detail',['id' => $mataId]),
            'link_accept_pelatihanKhusus' =>route('peserta.detailAkses', ['id' => $data['id_pelatihan_khusus']]),
            'type_pelatihan' => 'KHUSUS'
        ];
        Mail::to('contact@speakoud.com')->send(new \App\Mail\ActivateAccountMail($data));
        return redirect()->back()->with('success', 'Permintaan Akses Berhasil Di kirimkan, mohon tunggu sebentar kami akan mengirimkan pemberitahuan persetuajan lewat email anda');
    }

    public function detailAKses($id)
    {
        $data['pelatihanKhusus'] =$this->service->getMataKhusus($id);
        return view('backend.user_management.instruktur.pelatihanKhusus', compact('data'));
    }

    public function beriAkses(Request $request, $id)
    {
        $this->service->giveAccess($id, $request->instrukturId);
        $dataPeserta =$this->service->getPelatihanKhususInstruktur($request->instrukturId,$id);
        $data = [
            'email' =>$dataPeserta->instruktur->user->email, 
            'pelatihan' => $dataPeserta->pelatihan->judul,
            'link_speakoud' => route('home'),
            'link_pelatihan' => route('pelatihan.detail',['id' => $id])
        ];

        Mail::to($dataPeserta->instruktur->user->email)->send(new \App\Mail\SendEnrollProgramNotification($data));
        return redirect()->back()->with('success', 'Akses berhasil di berikan');
    }   
}
