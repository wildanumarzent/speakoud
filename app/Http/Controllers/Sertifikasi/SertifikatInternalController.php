<?php

namespace App\Http\Controllers\Sertifikasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\SertifikatInternalRequest;
use App\Services\Course\MataService;
use App\Services\Sertifikasi\SertifikatInternalService;
use Illuminate\Http\Request;

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
                'Sertifikat Internal' => ''
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
        $this->service->updateSertifikat($request, $id);

        return back()->with('success', 'sertifikat berhasil diubah');
    }

    public function cetak($mataId)
    {
        $this->service->cetakSertifikat($mataId);

        return back();
    }
}
