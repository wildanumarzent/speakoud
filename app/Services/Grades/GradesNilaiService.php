<?php

namespace App\Services\Grades;

use App\Models\Grades\GradesNilai;

class GradesNilaiService
{
    private $model;

    public function __construct(GradesNilai $model)
    {
        $this->model = $model;
    }

    public function getGradesNilaiList($request, int $kategoriId)
    {
        $query = $this->model->query();

        $query->where('kategori_id', $kategoriId);
        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('minimum', 'like', '%'.$q.'%')
                ->orWhere('maksimum', 'like', '%'.$q.'%')
                ->orWhere('keterangan', 'like', '%'.$q.'%');
            });
        });

        $result = $query->orderBy('maksimum', 'DESC')->paginate(20);

        return $result;
    }

    public function findGradesNilai(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeGradesNilai($request, int $kategoriId)
    {
        $nilai = new GradesNilai;
        $nilai->kategori_id = $kategoriId;
        $nilai->creator_id = auth()->user()->id;
        $nilai->minimum = $request->minimum;
        $nilai->maksimum = $request->maksimum;
        $nilai->keterangan = $request->keterangan;
        $nilai->save();

        return $nilai;
    }

    public function updateGradesNilai($request, int $id)
    {
        $nilai = $this->findGradesNilai($id);
        $nilai->minimum = $request->minimum;
        $nilai->maksimum = $request->maksimum;
        $nilai->keterangan = $request->keterangan;
        $nilai->save();

        return $nilai;
    }

    public function deleteGradesNilai(int $id)
    {
        $nilai = $this->findGradesNilai($id);

        $nilai->delete();

        return $nilai;
    }
}
