<?php

namespace App\Services\Instansi;

use App\Models\Instansi\InstansiInternal;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class InstansiInternalService
{
    private $model;

    public function __construct(InstansiInternal $model)
    {
        $this->model = $model;
    }

    public function getInstansiList($request)
    {
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('nip_pimpinan', 'like', '%'.$q.'%')
                ->orWhere('nama_pimpinan', 'like', '%'.$q.'%')
                ->orWhere('nama_instansi', 'like', '%'.$q.'%')
                ->orWhere('jabatan', 'like', '%'.$q.'%')
                ->orWhere('telpon', 'like', '%'.$q.'%')
                ->orWhere('fax', 'like', '%'.$q.'%');
            });
        });

        $result = $query->orderBy('id', 'ASC')->paginate(20);

        return $result;
    }

    public function getInstansi()
    {
        $query = $this->model->query();

        $result = $query->orderBy('id', 'ASC')->get();

        return $result;
    }

    public function findInstansi(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeInstansi($request)
    {
        if ($request->hasFile('logo')) {
            $fileName = str_replace(' ', '-', Str::random(5).'-'.$request->file('logo')
                ->getClientOriginalName());
            $request->file('logo')->move(public_path('userfile/logo_instansi'), $fileName);
        }

        $instansi = new InstansiInternal;
        $instansi->creator_id = auth()->user()->id;
        $instansi->nip_pimpinan = $request->nip_pimpinan;
        $instansi->nama_pimpinan = $request->nama_pimpinan;
        $instansi->nama_instansi = $request->nama_instansi;
        $instansi->jabatan = $request->jabatan;
        $instansi->telpon = $request->telpon ?? null;
        $instansi->fax = $request->fax ?? null;
        $instansi->logo = $fileName ?? null;
        $instansi->save();

        return $instansi;
    }

    public function updateInstansi($request, int $id)
    {
        if ($request->hasFile('logo')) {
            $fileName = str_replace(' ', '-', Str::random(5).'-'.$request->file('logo')
                ->getClientOriginalName());
            $this->deleteLogoFromPath($request->old_logo);
            $request->file('logo')->move(public_path('userfile/logo_instansi'), $fileName);
        }

        $instansi = $this->findInstansi($id);
        $instansi->nip_pimpinan = $request->nip_pimpinan;
        $instansi->nama_pimpinan = $request->nama_pimpinan;
        $instansi->nama_instansi = $request->nama_instansi;
        $instansi->jabatan = $request->jabatan;
        $instansi->telpon = $request->telpon ?? null;
        $instansi->fax = $request->fax ?? null;
        $instansi->logo = $fileName ?? $instansi->logo;
        $instansi->save();

        return $instansi;
    }

    public function deleteInstansi(int $id)
    {
        $instansi = $this->findInstansi($id);

        if (!empty($instansi->logo)) {
            $this->deleteLogoFromPath($instansi->logo);
        }
        $instansi->delete();

        return $instansi;
    }

    public function deleteLogoFromPath($fileName)
    {
        $path = public_path('userfile/logo_instansi/'.$fileName) ;
        File::delete($path);

        return $path;
    }
}
