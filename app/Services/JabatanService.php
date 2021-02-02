<?php

namespace App\Services;

use App\Models\Jabatan;

class JabatanService
{
    private $model;

    public function __construct(Jabatan $model)
    {
        $this->model = $model;
    }

    public function getJabatanList($request)
    {
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where('nama', 'ilike', '%'.$q.'%')
                ->orWhere('keterangan', 'ilike', '%'.$q.'%');
        });

        $result = $query->paginate(20);

        return $result;
    }

    public function getJabatan()
    {
        return $this->model->all();
    }

    public function findJabatan(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeJabatan($request)
    {
        $jabatan = new Jabatan($request->only(['nama']));
        $jabatan->keterangan = $request->keterangan ?? null;
        $jabatan->save();

        return $jabatan;
    }

    public function updateJabatan($request, int $id)
    {
        $jabatan = $this->findJabatan($id);
        $jabatan->fill($request->only(['nama']));
        $jabatan->keterangan = $request->keterangan ?? null;
        $jabatan->save();

        return $jabatan;
    }

    public function deleteJabatan(int $id)
    {
        $jabatan = $this->findJabatan($id);

        if ($jabatan->peserta->count() > 0) {

            return false;

        } else {

            $jabatan->delete();

            return true;
        }

    }
}
