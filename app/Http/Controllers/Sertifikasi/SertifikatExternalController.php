<?php

namespace App\Http\Controllers\Sertifikasi;

use App\Exports\MataPesertaExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\SertifikatExternalRequest;
use App\Services\Course\MataService;
use App\Services\Sertifikasi\SertifikatExternalService;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class SertifikatExternalController extends Controller
{
    private $service, $serviceMata;

    public function __construct(
        SertifikatExternalService $service,
        MataService $serviceMata
    )
    {
        $this->service = $service;
        $this->serviceMata = $serviceMata;
    }

    public function peserta(Request $request, $mataId)
    {
        $q = '';
        if (isset($request->q)) {
            $q = '?q='.$request->q;
        }

        $data['peserta'] = $this->serviceMata->getPesertaList($request, $mataId);
        $data['number'] = $data['peserta']->firstItem();
        $data['peserta']->withPath(url()->current().$q);
        $data['mata'] = $this->serviceMata->findMata($mataId);

        return view('backend.sertifikasi.sertifikat_external.peserta', compact('data'), [
            'title' => 'Course - Sertifikat External',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program Pelatihan' => route('mata.index', ['id' => $data['mata']->program_id]),
                'Sertifikat External' => ''
            ],
        ]);
    }

    public function detail($mataId, $pesertaId)
    {
        $data['sertifikat'] = $this->service->getSertifikatByPeserta($pesertaId);
        $data['mata'] = $this->serviceMata->findMata($mataId);

        return view('backend.sertifikasi.sertifikat_external.detail', compact('data'), [
            'title' => 'Course - Sertifikat - Detail',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program' => route('mata.index', ['id' => $data['mata']->program_id]),
                'Sertifikat' => route('sertifikat.external.peserta', ['id' => $mataId]),
                'Detail' => '',
            ],
        ]);
    }


    public function upload(SertifikatExternalRequest $request, $mataId)
    {
        $this->service->uploadSertifikat($request, $mataId);

        return back()->with('success', 'upload sertifikat berhasil');
    }

    public function export(Request $request, $mataId){
        $mata = $this->serviceMata->findMata($mataId);
        $peserta = $this->serviceMata->getPesertaList($request,$mataId,$paginate = false);
        return Excel::download(new MataPesertaExport($peserta,$mata), "data-peserta-{$mata->judul}.xlsx");
    }

    public function destroy($mataId, $pesertaId, $id)
    {
        $this->service->deleteSertifikat($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
