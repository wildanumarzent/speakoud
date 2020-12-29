<?php

namespace App\Services\Sertifikasi;

use App\Models\Sertifikasi\SertifikatExternal;
use App\Services\Course\MataService;
use Illuminate\Support\Facades\Storage;

class SertifikatExternalService
{
    private $model, $mata;

    public function __construct(
        SertifikatExternal $model,
        MataService $mata
    )
    {
        $this->model = $model;
        $this->mata = $mata;
    }

    public function getSertifikatByPeserta(int $pesertaId)
    {
        $query = $this->model->query();

        $query->where('peserta_id', $pesertaId);

        $result = $query->get();

        return $result;
    }

    public function findSertifikat(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function uploadSertifikat($request, int $mataId)
    {
        if ($request->hasFile('sertifikat')) {

            $file = $request->file('sertifikat');
            $fileName = str_replace(' ', '-', $file->getClientOriginalName());

            $sertifikat = new SertifikatExternal;
            $sertifikat->mata_id = $mataId;
            $sertifikat->creator_id = auth()->user()->id;
            $sertifikat->peserta_id = $request->peserta_id;
            $sertifikat->sertifikat = 'sertifikat_external/'.$request->peserta_id.'/'.$fileName;
            $sertifikat->save();

            Storage::disk('bank_data')->put('sertifikat_external/'.$request->peserta_id.'/'.$fileName, file_get_contents($file));

            return $sertifikat;
        } else {
            return false;
        }
    }

    public function deleteSertifikat(int $id)
    {
        $sertifikat = $this->findSertifikat($id);
        Storage::disk('bank_data')->delete($sertifikat->sertifikat);
        $sertifikat->delete();

        return $sertifikat;
    }
}
