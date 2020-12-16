<?php

namespace App\Services\Course;

use App\Models\Course\MateriPelatihan;
use App\Services\Users\InstrukturService;

class MateriService
{
    private $model, $mata, $instruktur;

    public function __construct(
        MateriPelatihan $model,
        MataService $mata,
        InstrukturService $instruktur
    )
    {
        $this->model = $model;
        $this->mata = $mata;
        $this->instruktur = $instruktur;
    }

    public function getMateriList($request, int $mataId)
    {
        $query = $this->model->query();

        $query->where('mata_id', $mataId);
        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('judul', 'like', '%'.$q.'%')
                    ->orWhere('keterangan', 'like', '%'.$q.'%');
            });
        });
        if (isset($request->p)) {
            $query->where('publish', $request->p);
        }

        $result = $query->orderBy('urutan', 'ASC')->paginate(9);

        return $result;
    }

    public function getMateriByMata(int $mataId)
    {
        $query = $this->model->query();

        $query->where('mata_id', $mataId);
        if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra')) {
            $query->where('instruktur_id', auth()->user()->instruktur->id);
        }

        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            $query->publish();
        }

        $result = $query->orderBy('urutan', 'ASC')->get();

        return $result;
    }

    public function countMateri()
    {
        $query = $this->model->query();

        if (auth()->user()->hasRole('internal')) {
            $query->whereHas('program', function ($query) {
                $query->where('tipe', 0);
            });
        }

        if (auth()->user()->hasRole('mitra')) {
            $query->whereHas('program', function ($query) {
                $query->where('mitra_id', auth()->user()->id)
                ->where('tipe', 1);
            });
        }

        $result = $query->count();

        return $result;
    }

    public function findMateri(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeMateri($request, int $mataId)
    {
        $mata = $this->mata->findMata($mataId);

        $materi = new MateriPelatihan($request->only(['judul']));
        $materi->program_id = $mata->program_id;
        $materi->mata_id = $mataId;
        $materi->instruktur_id = $request->instruktur_id;
        $materi->creator_id = auth()->user()->id;
        $materi->keterangan = $request->keterangan ?? null;
        $materi->publish = (bool)$request->publish;
        $materi->urutan = ($this->model->where('mata_id', $mataId)->max('urutan') + 1);
        $materi->save();

        return $materi;
    }

    public function updateMateri($request, int $id)
    {
        $materi = $this->findMateri($id);
        $materi->fill($request->only(['judul']));
        $materi->instruktur_id = $request->instruktur_id;
        $materi->keterangan = $request->keterangan ?? null;
        $materi->publish = (bool)$request->publish;
        $materi->save();

        return $materi;
    }

    public function positionMateri(int $id, $urutan)
    {
        if ($urutan >= 1) {

            $materi = $this->findMateri($id);
            $this->model->where('urutan', $urutan)->update([
                'urutan' => $materi->urutan,
            ]);
            $materi->urutan = $urutan;
            $materi->save();

            return $materi;
        } else {
            return false;
        }
    }

    public function sortMateri(int $id, $urutan)
    {
        $find = $this->findMateri($id);

        $materi = $this->model->where('id', $id)
                ->where('program_id', $find->program_id)->update([
            'urutan' => $urutan
        ]);

        return $materi;
    }

    public function publishMateri(int $id)
    {
        $materi = $this->findMateri($id);
        $materi->publish = !$materi->publish;
        $materi->save();

        return $materi;
    }

    public function deleteMateri(int $id)
    {
        $materi = $this->findMateri($id);

        $materi->delete();

        return $materi;
    }
}
