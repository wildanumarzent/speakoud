<?php

namespace App\Services\Users;

use App\Models\BankData;
use App\Models\Users\Peserta;
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

    public function getPesertaList($request)
    {
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('nip', 'like', '%'.$q.'%')
                ->orWhere('unit_kerja', 'like', '%'.$q.'%')
                ->orWhere('kedeputian', 'like', '%'.$q.'%')
                ->orWhere('pangkat', 'like', '%'.$q.'%')
                ->orWhere('alamat', 'like', '%'.$q.'%');
            });
        });

        if (auth()->user()->hasRole('internal')) {
            $query->whereHas('user', function ($queryB) {
                $queryB->whereHas('roles', function ($queryC) {
                    $queryC->where('name', 'peserta_internal');
                });
            });
        }

        if (auth()->user()->hasRole('mitra')) {
            $query->where('mitra_id', auth()->user()->mitra->id);
            $query->whereHas('user', function ($queryB) {
                $queryB->whereHas('roles', function ($queryC) {
                    $queryC->where('name', 'peserta_mitra');
                });
            });
        }

        $result = $query->orderBy('id', 'ASC')->paginate(20);

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
            if (auth()->user()->hasRole('mitra')) {
                $query->where('mitra_id', auth()->user()->mitra->id);
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

        if (auth()->user()->hasRole('mitra')) {
            $mitraId = auth()->user()->mitra->id;
        } else {
            $mitraId = $request->mitra_id;
        }

        $peserta = new Peserta;
        $peserta->user_id = $user->id;
        $peserta->creator_id = auth()->user()->id;
        $peserta->mitra_id = $mitraId ?? null;
        $peserta->nip = $request->nip ?? null;
        $peserta->instansi_id = $request->instansi_id ?? null;
        $peserta->kedeputian = $request->kedeputian ?? null;
        $peserta->pangkat = $request->pangkat ?? null;
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
        $peserta->instansi_id = $request->instansi_id ?? null;
        $peserta->kedeputian = $request->kedeputian ?? null;
        $peserta->pangkat = $request->pangkat ?? null;
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

        return $peserta;
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
