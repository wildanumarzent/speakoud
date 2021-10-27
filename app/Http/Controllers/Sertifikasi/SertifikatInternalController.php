<?php

namespace App\Http\Controllers\Sertifikasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\SertifikatInternalRequest;
use App\Services\Course\MataService;
use App\Services\Sertifikasi\SertifikatInternalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SertifikatInternalController extends Controller
{
    private $service, $serviceMata;

    public function __construct(
        SertifikatInternalService $service,
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

        $data['peserta'] = $this->service->getPesertaList($mataId);
        $data['number'] = $data['peserta']->firstItem();
        $data['peserta']->withPath(url()->current().$q);
        $data['mata'] = $this->serviceMata->findMata($mataId);
        return view('backend.sertifikasi.sertifikat_internal.peserta', compact('data'), [
            'title' => 'Course - Sertifikat Internal',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program Pelatihan' => route('mata.index', ['id' => $data['mata']->program_id]),
                'Sertifikat Internal' => ''
            ],
        ]);
    }

    public function form($mataId)
    {
        $data['mata'] = $this->serviceMata->findMata($mataId);

        if (!empty($data['mata']->sertifikatInternal)) {
            $data['sertifikat'] = $data['mata']->sertifikatInternal;
        }

        return view('backend.sertifikasi.sertifikat_internal.form', compact('data'), [
            'title' => 'Course - Sertifikat Internal',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program Pelatihan' => route('mata.index', ['id' => $data['mata']->program_id]),
                'Sertifikat Internal' => route('sertifikat.internal.peserta', ['id' => $mataId]),
                'Form' => '',
            ],
        ]);
    }

    public function store(SertifikatInternalRequest $request, $mataId)
    {
        $mata = $this->serviceMata->findMata($mataId);

        $this->service->storeSertifikat($request, $mataId);

        return redirect()->route('mata.index', ['id' => $mata->program_id])
            ->with('success', 'sertifikat berhasil dibuat');
    }

    public function update(SertifikatInternalRequest $request, $mataId, $id)
    {
        $sertifikat = $this->service->findSertifikat($id);

        if ($sertifikat->peserta->count() > 0) {
            return back()->with('success', 'sertifikat tidak bisa diubah, dikarenakan sudah ada peserta yang sudah generate');
        }

        $this->service->updateSertifikat($request, $id);

        return back()->with('success', 'sertifikat berhasil diubah');
    }

    public function cetak($mataId, $sertifikatId)
    {
        $mata = $this->serviceMata->findMata($mataId);

        if ($mata->bobot->bobotActivity($mataId, auth()->user()->id) < 10) {
            return back()->with('warning', 'Anda harus menyelesaikan semua materi');
        }

        if (empty(auth()->user()->photo['filename'])) {
            return back()->with('warning', 'Upload foto sertifikat terlebih dahulu di profile anda');
        }

        // $fileGen = storage_path('app/bank_data/'.$id.$sertifikatId);
        $this->service->cetakSertifikat($mataId, $sertifikatId);

        return back()->with('success', 'berhasil cetak sertifikat, silahkan untuk mendownload');
    }

    public function download($mataId, $sertifikatId)
    {
        $this->service->cetakSertifikatBelakang($mataId);

        return back();
    }
}
