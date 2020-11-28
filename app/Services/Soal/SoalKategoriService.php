<?php

namespace App\Services\Soal;

use App\Models\Soal\SoalKategori;

class SoalKategoriService
{
    private $model;

    public function __construct(SoalKategori $model)
    {
        $this->model = $model;
    }

    public function getSoalKategoriList($request)
    {
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('judul', 'like', '%'.$q.'%');
            });
        });

        $result = $query->paginate(20);

        return $result;
    }

    public function findKategoriSoal(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeKategoriSoal($request)
    {
        $kategori = new SoalKategori($request->only(['judul']));
        $kategori->creator_id = auth()->user()->id;
        $kategori->keterangan = $request->keterangan ?? null;
        $kategori->save();

        return $kategori;
    }

    public function updateKategoriSoal($request, int $id)
    {
        $kategori = $this->findKategoriSoal($id);
        $kategori->fill($request->only(['judul']));
        $kategori->keterangan = $request->keterangan ?? null;
        $kategori->save();

        return $kategori;
    }

    public function deleteKategoriSoal(int $id)
    {
        $kategori = $this->findKategoriSoal($id);
        $kategori->soal()->delete();
        $kategori->delete();

        return $kategori;
    }
}