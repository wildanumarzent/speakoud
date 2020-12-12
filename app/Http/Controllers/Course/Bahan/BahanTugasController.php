<?php

namespace App\Http\Controllers\Course\Bahan;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadTugasRequest;
use App\Services\Course\Bahan\BahanService;
use App\Services\Course\Bahan\BahanTugasService;
use Illuminate\Http\Request;

class BahanTugasController extends Controller
{
    private $service, $serviceBahan;

    public function __construct(
        BahanTugasService $service,
        BahanService $serviceBahan
    )
    {
        $this->service = $service;
        $this->serviceBahan = $serviceBahan;
    }

    public function peserta(Request $request, $tugasId)
    {
        $q = '';
        if (isset($request->q)) {
            $q = '?q='.$request->q;
        }

        $data['peserta'] = $this->service->getPesertaList($request, $tugasId);
        $data['number'] = $data['peserta']->firstItem();
        $data['peserta']->withPath(url()->current().$q);
        $data['tugas'] = $this->service->findTugas($tugasId);

        $this->serviceBahan->checkInstruktur($data['tugas']->materi_id);

        return view('frontend.course.tugas.peserta', compact('data'), [
            'title' => 'Tugas - Peserta',
            'breadcrumbsBackend' => [
                'Tugas' => route('course.bahan', [
                    'id' => $data['tugas']->mata_id,
                    'bahanId' => $data['tugas']->bahan_id,
                    'tipe' => 'tugas'
                ]),
                'Peserta' => ''
            ],
        ]);
    }

    public function sendTugas(UploadTugasRequest $request, $tugasId)
    {
        $this->service->sendTugas($request, $tugasId);

        return back()->with('success', 'Tugas berhasil dikirim');
    }
}
