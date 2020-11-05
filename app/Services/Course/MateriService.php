<?php

namespace App\Services\Course;

use App\Models\Course\MateriPelatihan;

class MateriService
{
    private $model, $mata;

    public function __construct(
        MateriPelatihan $model,
        MataService $mata
    )
    {
        $this->model = $model;
        $this->mata = $mata;
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
