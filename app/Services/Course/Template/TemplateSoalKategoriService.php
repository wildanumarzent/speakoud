<?php

namespace App\Services\Course\Template;

use App\Models\Course\Template\TemplateSoalKategori;

class TemplateSoalKategoriService
{
    private $model;

    public function __construct(TemplateSoalKategori $model)
    {
        $this->model = $model;
    }

    public function getTemplateSoalKategori(int $mataId)
    {
        $query = $this->model->query();

        $query->where('template_mata_id', $mataId);

        $result = $query->get();

        return $result;
    }

    public function getTemplateSoalKategoriList($request, int $mataId)
    {
        $query = $this->model->query();

        $query->where('template_mata_id', $mataId);
        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('judul', 'like', '%'.$q.'%');
            });
        });

        $result = $query->paginate(20);

        return $result;
    }

    public function findTemplateSoalKategori(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeTemplateSoalKategori($request, int $mataId)
    {
        $kategori = new TemplateSoalKategori($request->only(['judul']));
        $kategori->template_mata_id = $mataId;
        $kategori->creator_id = auth()->user()->id;
        $kategori->keterangan = $request->keterangan ?? null;
        $kategori->save();

        return $kategori;
    }

    public function updateTemplateSoalKategori($request, int $id)
    {
        $kategori = $this->findTemplateSoalKategori($id);
        $kategori->fill($request->only(['judul']));
        $kategori->keterangan = $request->keterangan ?? null;
        $kategori->save();

        return $kategori;
    }

    public function deleteTemplateSoalKategori(int $id)
    {
        $kategori = $this->findTemplateSoalKategori($id);

        if ($kategori->soal->count() > 0) {
            return false;
        } else {
            $kategori->delete();

            return true;
        }
    }
}
