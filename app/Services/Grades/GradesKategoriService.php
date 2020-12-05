<?php

namespace App\Services\Grades;

use App\Models\Grades\GradesKategori;

class GradesKategoriService
{
    private $model;

    public function __construct(GradesKategori $model)
    {
        $this->model = $model;
    }

    public function getGradesKategoriList($request)
    {
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('nama', 'like', '%'.$q.'%');
            });
        });

        $result = $query->paginate(20);

        return $result;
    }

    public function findGradesKategori(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeGradesKategori($request)
    {
        $kategori = new GradesKategori;
        $kategori->creator_id = auth()->user()->id;
        $kategori->nama = $request->nama;
        $kategori->keterangan = $request->keterangan ?? null;
        $kategori->save();

        return $kategori;
    }

    public function updateGradesKategori($request, int $id)
    {
        $kategori = $this->findGradesKategori($id);
        $kategori->nama = $request->nama;
        $kategori->keterangan = $request->keterangan ?? null;
        $kategori->save();

        return $kategori;
    }

    public function deleteGradesKategori(int $id)
    {
        $kategori = $this->findGradesKategori($id);

        $kategori->delete();

        return $kategori;
    }
}
