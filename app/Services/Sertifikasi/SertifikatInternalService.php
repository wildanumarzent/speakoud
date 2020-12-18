<?php

namespace App\Services\Sertifikasi;

use App\Models\Sertifikasi\SertifikatInternal;
use App\Services\Course\MataService;

class SertifikatInternalService
{
    private $model, $mata;

    public function __construct(
        SertifikatInternal $model,
        MataService $mata
    )
    {
        $this->model = $model;
        $this->mata = $mata;
    }

    public function findSertifikat(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeSertifikat($request, int $mataId)
    {
        $sertifikat = new SertifikatInternal;
        $sertifikat->mata_id = $mataId;
        $sertifikat->creator_id = auth()->user()->id;
        $sertifikat->nomor = $request->nomor;
        $sertifikat->tanggal = $request->tanggal;
        $sertifikat->nama_pimpinan = $request->nama_pimpinan;
        $sertifikat->jabatan = $request->jabatan;
        $sertifikat->save();
    }

    public function updateSertifikat($request, int $id)
    {
        $sertifikat = $this->findSertifikat($id);
        $sertifikat->nomor = $request->nomor;
        $sertifikat->tanggal = $request->tanggal;
        $sertifikat->nama_pimpinan = $request->nama_pimpinan;
        $sertifikat->jabatan = $request->jabatan;
        $sertifikat->save();

        return $sertifikat;
    }
}
