<?php

namespace App\Services\Users;

use App\Models\BankData;
use App\Models\Users\Mitra;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MitraService
{
    private $model, $modelBankData, $user;

    public function __construct(
        Mitra $model,
        BankData $modelBankData,
        UserService $user
    )
    {
        $this->model = $model;
        $this->modelBankData = $modelBankData;
        $this->user = $user;
    }

    public function getMitraAll()
    {
        $query = $this->model->query();

        $query->whereHas('user', function ($query) {
            $query->active();
        });

        $result = $query->orderBy('id', 'ASC')->get();

        return $result;
    }

    public function getMitraList($request)
    {
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('nip', 'like', '%'.$q.'%')
                ->orWhere('kedeputian', 'like', '%'.$q.'%')
                ->orWhere('pangkat', 'like', '%'.$q.'%')
                ->orWhere('alamat', 'like', '%'.$q.'%');
            });
        });

        $result = $query->orderBy('id', 'ASC')->paginate(20);

        return $result;
    }

    public function findMitra(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeMitra($request)
    {
        $user = $this->user->storeUser($request);

        $mitra = new Mitra;
        $mitra->user_id = $user->id;
        $mitra->creator_id = auth()->user()->id;
        $mitra->nip = $request->nip ?? null;
        $mitra->instansi_id = $request->instansi_id ?? null;
        $mitra->kedeputian = $request->kedeputian ?? null;
        $mitra->pangkat = $request->pangkat ?? null;
        $mitra->alamat = $request->alamat ?? null;
        $this->uploadFile($request, $mitra, $user->id, 'store');
        $mitra->save();

        $user->userable()->associate($mitra);
        $user->save();

        return [
            'user' => $user,
            'mitra' => $mitra
        ];
    }

    public function updateMitra($request, int $id)
    {
        $mitra = $this->findMitra($id);
        $mitra->nip = $request->nip ?? null;
        $mitra->instansi_id = $request->instansi_id ?? null;
        $mitra->kedeputian = $request->kedeputian ?? null;
        $mitra->pangkat = $request->pangkat ?? null;
        $mitra->alamat = $request->alamat ?? null;
        $this->uploadFile($request, $mitra, $mitra->user_id, 'update', $id);
        $mitra->save();

        $user = $mitra->user;
        $user->fill($request->only(['name', 'email', 'username']));
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        if ($request->email != $request->old_email) {
            $user->email_verified = 0;
            $user->email_verified_at = null;
        }
        $user->save();

        return [
            'mitra' => $mitra,
            'user' => $user
        ];
    }

    public function uploadFile($request, $mitra, $userId, $type, $id = null)
    {
        if ($id != null) {
            $find = $this->findMitra($id);
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

        $mitra->sk_cpns = [
            'file' => !empty($request->sk_cpns) ? $path.$cpns : ($type == 'store' ? null : $find->sk_cpns['file']),
            'keterangan' => $request->keterangan_cpns ?? ($type == 'store' ? null : $find->sk_cpns['keterangan']),
        ];
        $mitra->sk_pengangkatan = [
            'file' => !empty($request->sk_pengangkatan) ? $path.$pengangkatan : ($type == 'store' ? null : $find->sk_pengangkatan['file']),
            'keterangan' => $request->keterangan_pengangkatan ?? ($type == 'store' ? null : $find->sk_pengangkatan['keterangan']),
        ];
        $mitra->sk_golongan = [
            'file' => !empty($request->sk_golongan) ? $path.$golongan : ($type == 'store' ? null : $find->sk_golongan['file']),
            'keterangan' => $request->keterangan_golongan ?? ($type == 'store' ? null : $find->sk_golongan['keterangan']),
        ];
        $mitra->sk_jabatan = [
            'file' => !empty($request->sk_jabatan) ? $path.$jabatan : ($type == 'store' ? null : $find->sk_jabatan['file']),
            'keterangan' => $request->keterangan_jabatan ?? ($type == 'store' ? null : $find->sk_jabatan['keterangan']),
        ];

        return $mitra;
    }

    public function deleteMitra(int $id)
    {
        $mitra = $this->findMitra($id);
        $user = $mitra->user;
        $bankData = $this->modelBankData->where('owner_id', $user->id);

        if ($user->information()->count() > 0) {
            $user->information()->delete();
        }
        if (!empty($user->photo['file'])) {
            $path = public_path('userfile/photo/'.$user->photo['file']) ;
            File::delete($path);
        }

        if (!empty($mitra->sk_cpns['file'])) {
            Storage::disk('bank_data')->delete($mitra->sk_cpns['file']);
        }

        if (!empty($mitra->sk_pengangkatan['file'])) {
            Storage::disk('bank_data')->delete($mitra->sk_pengangkatan['file']);
        }

        if (!empty($mitra->golongan['file'])) {
            Storage::disk('bank_data')->delete($mitra->golongan['file']);
        }

        if (!empty($mitra->sk_jabatan['file'])) {
            Storage::disk('bank_data')->delete($mitra->sk_jabatan['file']);
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

        $mitra->delete();
        $mitra->user()->delete();

        return $mitra;
    }
}
