<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Services\Instansi\InstansiInternalService;
use App\Services\Instansi\InstansiMitraService;
use App\Services\JabatanService;
use App\Services\Users\MitraService;
use App\Services\Users\PesertaService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PesertaExport;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\PesertaRequest;

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
        $url = $request->url();
        $param = str_replace($url, '', $request->fullUrl());

        $data['peserta'] = $this->service->getPesertaList($request);
        $data['no'] = $data['peserta']->firstItem();
        $data['peserta']->withPath(url()->current().$param);

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

    public function updatePesertaKhusus(Request $request, $id)
    {
        $this->service->giveAccess($id, $request->pesertaId);
        $dataPeserta =$this->service->getPelatihanKhusus($id, $request->pesertaId);
        $data = [
            'email' =>$dataPeserta->peserta->user->email, 
            'pelatihan' => $dataPeserta->pelatihan->judul,
            'link_speakoud' => route('home'),
            'link_pelatihan' => route('pelatihan.detail',['id' => $id])
        ];

        Mail::to($dataPeserta->peserta->user->email)->send(new \App\Mail\SendEnrollProgramNotification($data));
        return redirect()->back()->with('success', 'Akses berhasil di berikan');
    }

    public function mintaAkses_pelatihan($mataId, $id)
    {
        $data= $this->service->MintaAkses($mataId,$id);
        $dataPeserta =$this->service->findPlatihanKhusus($id);
        $data = [
            'email' =>$dataPeserta->peserta->user->email, 
            'pelatihan' => $dataPeserta->pelatihan->judul,
            'nama_peserta' => $dataPeserta->peserta->user->name,
            'link_speakoud' => route('home'),
            'link_login' => route('login'),
            'link_manage_user_request' => route('peserta.index'),
            'link_pelatihan' => route('pelatihan.detail',['id' => $mataId]),
            'link_accept_pelatihanKhusus' =>route('peserta.detailAkses', ['id' => $dataPeserta->id]),
        ];

        Mail::to('contanct@speakoud.com')->send(new \App\Mail\ActivateAccountMail($data));
        return redirect()->back()->with('success', 'Permintaan Akses Berhasil Di kirimkan, tunggu hingga di setujui');
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

    public function detailAKses($id)
    {

        $data['peserta'] =$this->service->findPesertaKhusus($id);
        $data['pelatihanKhusus'] =$this->service->getMataKhusus($data['peserta']->mata_id,$data['peserta']->peserta_id);
        // dd( $data['pelatihanKhusus']);
        return view('backend.user_management.peserta.pelatihanKhusus', compact('data'));
    }   

    public function export(Request $request)
    {
        $peserta = $this->service->getPesertaList($request,$paginate = false);
        
        return Excel::download(new PesertaExport($peserta), 'data-peserta.xlsx');
    }
}
