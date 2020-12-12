<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanEvaluasiPengajar;
use App\Models\Course\MataInstruktur;

class BahanEvaluasiPengajarService
{
    private $model, $modelInstruktur;

    public function __construct(
        BahanEvaluasiPengajar $model,
        MataInstruktur $modelInstruktur
    )
    {
        $this->model = $model;
        $this->modelInstruktur = $modelInstruktur;
    }

    public function getBahanByMata(int $mataId)
    {
        return $this->model->where('mata_id', $mataId)->get();
    }

    public function storeEvaluasiPengajar($request, $materi, $bahan)
    {
        $evaluasi = new BahanEvaluasiPengajar;
        $evaluasi->program_id = $materi->program_id;
        $evaluasi->mata_id = $materi->mata_id;
        $evaluasi->materi_id = $materi->id;
        $evaluasi->bahan_id = $bahan->id;
        $evaluasi->creator_id = auth()->user()->id;
        $evaluasi->mata_instruktur_id = $request->mata_instruktur_id;
        $evaluasi->save();

        return $evaluasi;
    }

    public function updateEvaluasiPengajar($request, $bahan)
    {
        $evaluasi = $bahan->evaluasiPengajar;
        // $evaluasi->mata_instruktur_id = $request->mata_instruktur_id;
        $evaluasi->save();

        return $evaluasi;
    }
}
