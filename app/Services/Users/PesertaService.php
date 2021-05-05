<?php

namespace App\Services\Users;

use App\Models\BankData;
use App\Models\Course\MataPeserta;
use App\Models\Users\Peserta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PesertaService
{
    private $model, $modelBankData, $user;

    public function __construct(
        Peserta $model,
        BankData $modelBankData,
        UserService $user
    )
    {
        $this->model = $model;
        $this->modelBankData = $modelBankData;
        $this->user = $user;
    }

    public function getPesertaList($request, $paginate = true)
    {
        $query = $this->model->query();

        $query->when($request->t, function ($query, $t) {
            $query->whereHas('user', function ($queryB) use ($t) {
                $queryB->whereHas('roles', function ($queryC) use ($t) {
                    $queryC->where('id', $t);
                });
            });
        })->when($request->j, function ($query, $j) {
            $query->where(function ($query) use ($j) {
                $query->where('pangkat', $j);
            });
        })->when($request->q, function ($query, $q) {
            $query->where(function ($queryA) use ($q) {
                $queryA->whereHas('user', function (Builder $queryB) use ($q) {
                    $queryB->where('name', 'ilike', '%'.$q.'%')
                        ->orWhere('username', 'ilike', '%'.$q.'%');
                })->orWhere('nip', 'ilike', '%'.$q.'%')
                    ->orWhere('kedeputian', 'ilike', '%'.$q.'%');
            });
        });

        if (Auth::user()->hasRole('internal')) {
            $query->whereHas('user', function ($queryC) {
                $queryC->whereHas('roles', function ($queryD) {
                    $queryD->where('name', 'peserta_internal');
                });
            });
        }

        if (Auth::user()->hasRole('mitra')) {
            $query->where('mitra_id', Auth::user()->mitra->id);
            $query->whereHas('user', function ($queryE) {
                $queryE->whereHas('roles', function ($queryF) {
                    $queryF->where('name', 'peserta_mitra');
                });
            });
        }

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->orderBy('id', 'ASC')->paginate($limit);

        if($paginate == false){
            $result = $query->get();
        }
        
        return $result;
    }

    public function getPesertaForMata($type, $pesertaId)
    {
        $query = $this->model->query();

        $query->whereHas('user', function ($query) {
            $query->active();
        });
        if ($type == false) {
            $query->whereNull('mitra_id');
        } else {
            if (Auth::user()->hasRole('mitra')) {
                $query->where('mitra_id', Auth::user()->mitra->id);
            } else {
                $query->whereNotNull('mitra_id');
            }
        }

        $query->where(function ($query) use ($pesertaId) {
            $query->whereNotIn('id', $pesertaId);
        });

        $result = $query->get();

        return $result;
    }

    public function countPeserta()
    {
        $query = $this->model->query();

        $query->whereHas('user', function ($query) {
            $query->active();
        });

        $result = $query->count();

        return $result;
    }

    public function findPeserta(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storePeserta($request)
    {
        $user = $this->user->storeUser($request);

        if (Auth::user()->hasRole('mitra')) {
            $mitraId = Auth::user()->mitra->id;
        } else {
            $mitraId = $request->mitra_id;
        }

        $peserta = new Peserta;
        $peserta->user_id = $user->id;
        $peserta->creator_id = Auth::user()->id;
        $peserta->mitra_id = $mitraId ?? null;
        $peserta->nip = $request->nip ?? null;
        $peserta->jenis_peserta = $request->jenis_peserta ?? null;
        $peserta->jenis_kelamin = $request->jenis_kelamin ?? null;
        $peserta->agama = $request->agama ?? null;
        $peserta->tempat_lahir = $request->tempat_lahir ?? null;
        $peserta->tanggal_lahir = $request->tanggal_lahir ?? null;
        $peserta->pangkat = $request->pangkat ?? null;
        $peserta->golongan = $request->pangkat ?? null;
        $peserta->jabatan_id = $request->jabatan_id ?? null;
        $peserta->jenjang_jabatan = $request->jenjang_jabatan ?? null;
        $peserta->instansi_id = $request->instansi_id ?? null;
        $peserta->kedeputian = $request->kedeputian ?? null;

        if (!empty($request->kedeputian) && $request->pangkat >= 0 &&
            !empty($request->tempat_lahir) && !empty($request->tanggal_lahir) &&
            $request->jenis_peserta >= 0  && $request->agama >= 0 &&
            $request->jenis_kelamin >= 0  && !empty($request->jabatan_id) &&
            $request->jenjang_jabatan >= 0  && !empty($request->phone)) {
            $peserta->status_profile = 1;
        }

        $this->uploadFile($request, $peserta, $user->id, 'store');
        $peserta->save();

        $user->userable()->associate($peserta);
        $user->save();

        return [
            'user' => $user,
            'peserta' => $peserta
        ];
    }

    public function registerPeserta($request)
    {
        $user = $this->user->storeUser($request, 'register');

        $peserta = new Peserta;
        $peserta->user_id = $user->id;
        $peserta->nip = $request->nip ?? null;
        $peserta->instansi_id = $request->instansi_id ?? null;
        $peserta->kedeputian = $request->kedeputian ?? null;
        $peserta->pangkat = $request->pangkat ?? null;
        $peserta->sk_cpns = [
            'file' => null,
            'keterangan' => null,
        ];
        $peserta->sk_pengangkatan = [
            'file' => null,
            'keterangan' => null,
        ];
        $peserta->sk_golongan = [
            'file' => null,
            'keterangan' => null,
        ];
        $peserta->sk_jabatan = [
            'file' => null,
            'keterangan' => null,
        ];
        $peserta->surat_ijin_atasan = [
            'file' => null,
            'keterangan' => null,
        ];
        $peserta->save();

        $user->userable()->associate($peserta);
        $user->save();

        return [
            'user' => $user,
            'peserta' => $peserta
        ];
    }

    public function updatePeserta($request, int $id)
    {
        $peserta = $this->findPeserta($id);
        $peserta->nip = $request->nip ?? null;
        $peserta->jenis_peserta = $request->jenis_peserta ?? null;
        $peserta->jenis_kelamin = $request->jenis_kelamin ?? null;
        $peserta->agama = $request->agama ?? null;
        $peserta->tempat_lahir = $request->tempat_lahir ?? null;
        $peserta->tanggal_lahir = $request->tanggal_lahir ?? null;
        $peserta->pangkat = $request->pangkat ?? null;
        $peserta->golongan = $request->pangkat ?? null;
        $peserta->jabatan_id = $request->jabatan_id ?? null;
        $peserta->jenjang_jabatan = $request->jenjang_jabatan ?? null;
        $peserta->instansi_id = $request->instansi_id ?? null;
        $peserta->kedeputian = $request->kedeputian ?? null;

        if (!empty($request->kedeputian) && $request->pangkat >= 0 &&
            !empty($request->tempat_lahir) && !empty($request->tanggal_lahir) &&
            $request->jenis_peserta >= 0  && $request->agama >= 0 &&
            $request->jenis_kelamin >= 0  && !empty($request->jabatan_id) &&
            $request->jenjang_jabatan >= 0  && !empty($request->phone)) {
            $peserta->status_profile = 1;
        } else {
            $peserta->status_profile = 0;
        }

        $this->uploadFile($request, $peserta, $peserta->user_id, 'update', $id);
        $peserta->save();

        $user = $peserta->user;
        $user->fill($request->only(['name', 'email', 'username']));

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->email != $request->oldemail) {
            $user->email_verified = 0;
            $user->email_verified_at = null;
        }
        
        $user->save();
        $this->user->updateInformation($request, $user->id);

        return [
            'peserta' => $peserta,
            'user' => $user
        ];
    }

    public function uploadFile($request, $peserta, $userId, $type, $id = null)
    {
        if ($id != null) {
            $find = $this->findPeserta($id);
        }

        $path = 'surat_keterangan/'.$userId.'/';
        if ($request->hasFile('sk_cpns')) {
            $file = $request->file('sk_cpns');
            $cpns = str_replace(' ', '-', $file->getClientOriginalName());

            Storage::disk('bank_data')->delete($request->old_sk_cpns);
            Storage::disk('bank_data')->put($path.$cpns, file_get_contents($file));
        }
        if ($request->hasFile('sk_pengangkatan')) {
            $file = $request->file('sk_pengangkatan');
            $pengangkatan = str_replace(' ', '-', $file->getClientOriginalName());

            Storage::disk('bank_data')->delete($request->old_sk_pengangkatan);
            Storage::disk('bank_data')->put($path.$pengangkatan, file_get_contents($file));
        }
        if ($request->hasFile('sk_golongan')) {
            $file = $request->file('sk_golongan');
            $golongan = str_replace(' ', '-', $file->getClientOriginalName());

            Storage::disk('bank_data')->delete($request->old_sk_golongan);
            Storage::disk('bank_data')->put($path.$golongan, file_get_contents($file));
        }

        if ($request->hasFile('sk_jabatan')) {
            $file = $request->file('sk_jabatan');
            $jabatan = str_replace(' ', '-', $file->getClientOriginalName());

            Storage::disk('bank_data')->delete($request->old_sk_jabatan);
            Storage::disk('bank_data')->put($path.$jabatan, file_get_contents($file));
        }

        if ($request->hasFile('surat_ijin_atasan')) {
            $file = $request->file('surat_ijin_atasan');
            $atasan = str_replace(' ', '-', $file->getClientOriginalName());

            Storage::disk('bank_data')->delete($request->old_surat_ijin_atasan);
            Storage::disk('bank_data')->put($path.$atasan, file_get_contents($file));
        }

        if ($request->hasFile('foto_sertifikat')) {
            $fotoSertifikat = str_replace(' ', '-', $request->file('foto_sertifikat')
                ->getClientOriginalName());
            $request->file('foto_sertifikat')->move(public_path('userfile/photo/sertifikat'), $fotoSertifikat);

            $path = public_path('userfile/photo/sertifikat/'.$request->old_foto_sertifikat) ;
            File::delete($path);
        }

        $peserta->sk_cpns = [
            'file' => !empty($request->sk_cpns) ? $path.$cpns : ($type == 'store' ? null : $find->sk_cpns['file']),
            'keterangan' => $request->keterangan_cpns ?? ($type == 'store' ? null : $find->sk_cpns['keterangan']),
        ];
        $peserta->sk_pengangkatan = [
            'file' => !empty($request->sk_pengangkatan) ? $path.$pengangkatan : ($type == 'store' ? null : $find->sk_pengangkatan['file']),
            'keterangan' => $request->keterangan_pengangkatan ?? ($type == 'store' ? null : $find->sk_pengangkatan['keterangan']),
        ];
        $peserta->sk_golongan = [
            'file' => !empty($request->sk_golongan) ? $path.$golongan : ($type == 'store' ? null : $find->sk_golongan['file']),
            'keterangan' => $request->keterangan_golongan ?? ($type == 'store' ? null : $find->sk_golongan['keterangan']),
        ];
        $peserta->sk_jabatan = [
            'file' => !empty($request->sk_jabatan) ? $path.$jabatan : ($type == 'store' ? null : $find->sk_jabatan['file']),
            'keterangan' => $request->keterangan_jabatan ?? ($type == 'store' ? null : $find->sk_jabatan['keterangan']),
        ];
        $peserta->surat_ijin_atasan = [
            'file' => !empty($request->surat_ijin_atasan) ? $path.$atasan : ($type == 'store' ? null : $find->surat_ijin_atasan['file']),
            'keterangan' => $request->keterangan_atasan ?? ($type == 'store' ? null : $find->surat_ijin_atasan['keterangan']),
        ];
        $peserta->foto_sertifikat = !empty($request->foto_sertifikat) ? $fotoSertifikat : ($type == 'store' ? null : $find->foto_sertifikat);

        return $peserta;
    }

    public function softDeletePeserta(int $id)
    {
        $checkProgram = MataPeserta::where('peserta_id', $id)->count();

        if ($checkProgram > 0) {

            return false;
        } else {

            $peserta = $this->findPeserta($id);
            $peserta->user->delete();
            $peserta->delete();

            return true;
        }
    }

    public function deletePeserta(int $id)
    {
        $peserta = $this->findPeserta($id);
        $user = $peserta->user;
        $bankData = $this->modelBankData->where('owner_id', $user->id);

        if ($user->information()->count() > 0) {
            $user->information()->delete();
        }
        if (!empty($user->photo['file'])) {
            $path = public_path('userfile/photo/'.$user->photo['file']) ;
            File::delete($path);
        }

        if (!empty($peserta->sk_cpns['file'])) {
            Storage::disk('bank_data')->delete($peserta->sk_cpns['file']);
        }

        if (!empty($peserta->sk_pengangkatan['file'])) {
            Storage::disk('bank_data')->delete($peserta->sk_pengangkatan['file']);
        }

        if (!empty($peserta->sk_golongan['file'])) {
            Storage::disk('bank_data')->delete($peserta->sk_golongan['file']);
        }

        if (!empty($peserta->sk_jabatan['file'])) {
            Storage::disk('bank_data')->delete($peserta->sk_jabatan['file']);
        }

        if (!empty($peserta->surat_ijin_atasan['file'])) {
            Storage::disk('bank_data')->delete($peserta->surat_ijin_atasan['file']);
        }

        if ($bankData->count() > 0) {
            foreach ($bankData->get() as $value) {
                Storage::disk('bank_data')->delete($value->file_path);
                if ($value->thumbnail != null) {
                    Storage::disk('bank_data')->delete($value->thumbnail);
                }
                $value->delete();
            }
        }

        $peserta->delete();
        $peserta->user()->delete();

        return $peserta;
    }
}
