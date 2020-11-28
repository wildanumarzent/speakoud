<?php

namespace App\Services\Soal;

use App\Models\Soal\Soal;

class SoalService
{
    private $model;

    public function __construct(Soal $model)
    {
        $this->model = $model;
    }

    public function getSoalList($request, int $kategoriId)
    {
        $query = $this->model->query();

        $query->where('kategori_id', $kategoriId);
        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('pertanyaan', 'like', '%'.$q.'%');
            });
        });

        if (isset($request->t)) {
            $query->where('tipe_jawaban', $request->t);
        }

        $result = $query->paginate(20);

        return $result;
    }

    public function findSoal(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeSoal($request, int $kategoriId)
    {
        $soal = new Soal($request->only(['pertanyaan']));
        $soal->kategori_id = $kategoriId;
        $soal->creator_id = auth()->user()->id;
        $soal->tipe_jawaban = $request->get('tipe');
        if ($request->get('tipe') == 0) {
            $soal->pilihan = $request->pilihan;
            $soal->jawaban = $request->jawaban;

        } elseif ($request->get('tipe') == 1 || $request->get('tipe') == 3) {
            $soal->jawaban = $request->jawaban;
        }
        $soal->save();

        return $soal;
    }

    public function updateSoal($request, int $id)
    {
        $soal = $this->findSoal($id);
        $soal->fill($request->only(['pertanyaan']));
        if ($soal->tipe_jawaban == 0) {
            $soal->pilihan = $request->pilihan;
            $soal->jawaban = $request->jawaban;

        } elseif ($soal->tipe_jawaban == 1 || $soal->tipe_jawaban == 3) {
            $soal->jawaban = $request->jawaban;
        }
        $soal->save();

        return $soal;
    }

    public function deleteSoal(int $id)
    {
        $soal = $this->findSoal($id);
        $soal->delete();

        return $soal;
    }
}