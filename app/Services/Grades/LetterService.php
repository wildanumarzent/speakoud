<?php

namespace App\Services\Grades;

use App\Models\Grades\PersenNilai;

class LetterService
{
    private $model;

    public function __construct(PersenNilai $model)
    {
        $this->model = $model;
    }

    public function getLetterList($request)
    {
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('nilai_minimum', 'like', '%'.$q.'%')
                ->orWhere('nilai_maksimum', 'like', '%'.$q.'%')
                ->orWhere('angka', 'like', '%'.$q.'%');
            });
        });

        $result = $query->orderBy('nilai_maksimum', 'DESC')->paginate(20);

        return $result;
    }

    public function findLetter(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeLetter($request)
    {
        $letter = new PersenNilai();
        $letter->creator_id = auth()->user()->id;
        $letter->nilai_minimum = $request->nilai_minimum;
        $letter->nilai_maksimum = $request->nilai_maksimum;
        $letter->angka = strtoupper($request->angka);
        $letter->save();

        return $letter;
    }

    public function updateLetter($request, int $id)
    {
        $letter = $this->findLetter($id);
        $letter->nilai_minimum = $request->nilai_minimum;
        $letter->nilai_maksimum = $request->nilai_maksimum;
        $letter->angka = strtoupper($request->angka);
        $letter->save();

        return $letter;
    }

    public function deleteLetter(int $id)
    {
        $letter = $this->findLetter($id);

        $letter->delete();

        return $letter;
    }
}
