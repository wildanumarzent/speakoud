<?php

namespace App\Services\Instansi;

use App\Models\Instansi\InstansiInternal;
use App\Models\Users\Instruktur;
use App\Models\Users\Peserta;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class InstansiInternalService
{
    private $model, $modelInstruktur, $modelPeserta;

    public function __construct(
        InstansiInternal $model,
        Instruktur $modelInstruktur,
        Peserta $modelPeserta
    )
    {
        $this->model = $model;
        $this->modelInstruktur = $modelInstruktur;
        $this->modelPeserta = $modelPeserta;
    }

    public function getInstansiList($request)
    {
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('kode_instansi', 'ilike', '%'.$q.'%')
                ->orWhere('nip_pimpinan', 'ilike', '%'.$q.'%')
                ->orWhere('nama_pimpinan', 'ilike', '%'.$q.'%')
                ->orWhere('nama_instansi', 'ilike', '%'.$q.'%')
                ->orWhere('jabatan', 'ilike', '%'.$q.'%')
                ->orWhere('telpon', 'ilike', '%'.$q.'%')
                ->orWhere('fax', 'ilike', '%'.$q.'%');
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
        $instansi->kode_instansi = $request->kode_instansi ?? null;
        $instansi->nip_pimpinan = $request->nip_pimpinan;
        $instansi->nama_pimpinan = $request->nama_pimpinan;
        $instansi->nama_instansi = $request->nama_instansi;
        $instansi->jabatan = $request->jabatan;
        $instansi->telpon = $request->telpon ?? null;
        $instansi->fax = $request->fax ?? null;
        $instansi->logo = $fileName ?? null;
        $instansi->alamat = $request->alamat ?? null;
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
        $instansi->kode_instansi = $request->kode_instansi ?? null;
        $instansi->nip_pimpinan = $request->nip_pimpinan;
        $instansi->nama_pimpinan = $request->nama_pimpinan;
        $instansi->nama_instansi = $request->nama_instansi;
        $instansi->jabatan = $request->jabatan;
        $instansi->telpon = $request->telpon ?? null;
        $instansi->fax = $request->fax ?? null;
        $instansi->logo = $fileName ?? $instansi->logo;
        $instansi->alamat = $request->alamat ?? null;
        $instansi->save();

        return $instansi;
    }

    public function deleteInstansi(int $id)
    {
        $instansi = $this->findInstansi($id);

        //checkInstruktur
        $instruktur = $this->modelInstruktur->where('instansi_id', $id)
            ->whereNull('mitra_id')->count();
        //checkPeserta
        $peserta = $this->modelPeserta->where('instansi_id', $id)
            ->whereNull('mitra_id')->count();

        if (!empty($instansi->logo)) {
            $this->deleteLogoFromPath($instansi->logo);
        }

        if ($instansi->internal()->count() > 0 || $instruktur > 0 || $peserta > 0) {
            return false;
        } else {
            $instansi->delete();
        }

        return $instansi;
    }

    public function deleteLogoFromPath($fileName)
    {
        $path = public_path('userfile/logo_instansi/'.$fileName) ;
        File::delete($path);

        return $path;
    }
}
