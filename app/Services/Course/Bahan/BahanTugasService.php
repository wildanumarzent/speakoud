<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanTugas;
use App\Models\Course\Bahan\BahanTugasRespon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BahanTugasService
{
    private $model, $modelRespon;

    public function __construct(
        BahanTugas $model,
        BahanTugasRespon $modelRespon
    )
    {
        $this->model = $model;
        $this->modelRespon = $modelRespon;
    }

    public function getPesertaList($request, int $tugasId)
    {
        $query = $this->modelRespon->query();

        $query->where('tugas_id', $tugasId);

        $query->when($request->q, function ($query, $q) {
            return $query->whereHas('user', function ($query) use ($q) {
                $query->where('name', $q);
            });
        })->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('keterangan', 'like', '%'.$q.'%');
            });
        });

        $result = $query->paginate(20);

        return $result;
    }

    public function findTugas(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeTugas($request, $materi, $bahan)
    {
        if ($request->hasFile('files')) {

            $tugas = new BahanTugas;
            $tugas->program_id = $materi->program_id;
            $tugas->mata_id = $materi->mata_id;
            $tugas->materi_id = $materi->id;
            $tugas->bahan_id = $bahan->id;
            $tugas->creator_id = auth()->user()->id;

            foreach ($request->file('files') as $file) {

                $replace = str_replace(' ', '-', $file->getClientOriginalName());
                $files[] = 'tugas/'.$materi->id.'/'.auth()->user()->id.'/'.$replace;

                Storage::disk('bank_data')->put('tugas/'.$materi->id.'/'.auth()->user()->id.'/'.$replace, file_get_contents($file));
            }

            $tugas->files = $files;
            $tugas->save();

        } else {
            return false;
        }
    }

    public function updateTugas($request, $bahan)
    {
        $tugas = $bahan->tugas;
        $tugas->save();

        return $tugas;
    }

    public function sendTugas($request, $tugasId)
    {
        $tugas = $this->findTugas($tugasId);

        if ($request->hasFile('files')) {

            $respon = new BahanTugasRespon($request->only(['keterangan']));
            $respon->tugas_id = $tugasId;
            $respon->user_id = auth()->user()->id;
            foreach ($request->file('files') as $file) {

                $replace = str_replace(' ', '-', $file->getClientOriginalName());
                $files[] = 'tugas/'.$tugas->materi_id.'/'.auth()->user()->id.'/'.$replace;

                Storage::disk('bank_data')->put('tugas/'.$tugas->materi_id.'/'.$tugas->creator_id.'/respon/'.auth()->user()->id.'/'.$replace, file_get_contents($file));
            }

            $respon->files = $files;
            $respon->save();

        } else {
            return false;
        }
    }
}
