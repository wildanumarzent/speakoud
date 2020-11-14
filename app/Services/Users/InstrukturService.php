<?php

namespace App\Services\Users;

use App\Models\BankData;
use App\Models\Users\Instruktur;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class InstrukturService
{
    private $model, $modelBankData, $user;

    public function __construct(
        Instruktur $model,
        BankData $modelBankData,
        UserService $user
    )
    {
        $this->model = $model;
        $this->modelBankData = $modelBankData;
        $this->user = $user;
    }

    public function getInstrukturList($request)
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
                    $queryC->where('name', 'instruktur_internal');
                });
            });
        }

        if (auth()->user()->hasRole('mitra')) {
            $query->where('mitra_id', auth()->user()->mitra->id);
            $query->whereHas('user', function ($queryB) {
                $queryB->whereHas('roles', function ($queryC) {
                    $queryC->where('name', 'instruktur_mitra');
                });
            });
        }

        $result = $query->orderBy('id', 'ASC')->paginate(20);

        return $result;
    }

    public function getInstrukturForMata($type)
    {
        $query = $this->model->query();

        $query->whereHas('user', function ($query) {
            $query->active();
        });
        if ($type == 0) {
            $query->whereNull('mitra_id');
        } else {
            if (auth()->user()->hasRole('mitra')) {
                $query->where('mitra_id', auth()->user()->mitra->id);
            } else {
                $query->whereNotNull('mitra_id');
            }
        }

        $result = $query->get();

        return $result;
    }

    public function findInstruktur(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeInstruktur($request)
    {
        $user = $this->user->storeUser($request);

        $instruktur = new Instruktur;
        $instruktur->user_id = $user->id;
        $instruktur->creator_id = auth()->user()->id;
        $instruktur->mitra_id = $request->mitra_id ?? null;
        $instruktur->nip = $request->nip ?? null;
        $instruktur->unit_kerja = $request->unit_kerja ?? null;
        $instruktur->kedeputian = $request->kedeputian ?? null;
        $instruktur->pangkat = $request->pangkat ?? null;
        $instruktur->alamat = $request->alamat ?? null;
        $this->uploadFile($request, $instruktur, $user->id, 'store');
        $instruktur->save();

        $user->userable()->associate($instruktur);
        $user->save();

        return [
            'user' => $user,
            'instruktur' => $instruktur
        ];
    }

    public function updateInstruktur($request, int $id)
    {
        $instruktur = $this->findInstruktur($id);
        $instruktur->nip = $request->nip ?? null;
        $instruktur->unit_kerja = $request->unit_kerja ?? null;
        $instruktur->kedeputian = $request->kedeputian ?? null;
        $instruktur->pangkat = $request->pangkat ?? null;
        $instruktur->alamat = $request->alamat ?? null;
        $this->uploadFile($request, $instruktur, $instruktur->user_id, 'update', $id);
        $instruktur->save();

        $user = $instruktur->user;
        $user->fill($request->only(['name', 'email', 'username']));
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        if ($request->email != $request->oldemail) {
            $user->email_verified = 0;
            $user->email_verified_at = null;
        }
        $user->save();

        return [
            'instruktur' => $instruktur,
            'user' => $user
        ];
    }

    public function uploadFile($request, $instruktur, $userId, $type, $id = null)
    {
        if ($id != null) {
            $find = $this->findInstruktur($id);
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

        $instruktur->sk_cpns = [
            'file' => !empty($request->sk_cpns) ? $path.$cpns : ($type == 'store' ? null : $find->sk_cpns['file']),
            'keterangan' => $request->keterangan_cpns ?? ($type == 'store' ? null : $find->sk_cpns['keterangan']),
        ];
        $instruktur->sk_pengangkatan = [
            'file' => !empty($request->sk_pengangkatan) ? $path.$pengangkatan : ($type == 'store' ? null : $find->sk_pengangkatan['file']),
            'keterangan' => $request->keterangan_pengangkatan ?? ($type == 'store' ? null : $find->sk_pengangkatan['keterangan']),
        ];
        $instruktur->sk_golongan = [
            'file' => !empty($request->sk_golongan) ? $path.$golongan : ($type == 'store' ? null : $find->sk_golongan['file']),
            'keterangan' => $request->keterangan_golongan ?? ($type == 'store' ? null : $find->sk_golongan['keterangan']),
        ];
        $instruktur->sk_jabatan = [
            'file' => !empty($request->sk_jabatan) ? $path.$jabatan : ($type == 'store' ? null : $find->sk_jabatan['file']),
            'keterangan' => $request->keterangan_jabatan ?? ($type == 'store' ? null : $find->sk_jabatan['keterangan']),
        ];

        return $instruktur;
    }

    public function deleteInstruktur(int $id)
    {
        $instruktur = $this->findInstruktur($id);
        $user = $instruktur->user;
        $bankData = $this->modelBankData->where('owner_id', $user->id);

        if ($user->information()->count() > 0) {
            $user->information()->delete();
        }
        if (!empty($user->photo['file'])) {
            $path = public_path('userfile/photo/'.$user->photo['file']) ;
            File::delete($path);
        }

        if (!empty($instruktur->sk_cpns['file'])) {
            Storage::disk('bank_data')->delete($instruktur->sk_cpns['file']);
        }

        if (!empty($instruktur->sk_pengangkatan['file'])) {
            Storage::disk('bank_data')->delete($instruktur->sk_pengangkatan['file']);
        }

        if (!empty($instruktur->golongan['file'])) {
            Storage::disk('bank_data')->delete($instruktur->golongan['file']);
        }

        if (!empty($instruktur->sk_jabatan['file'])) {
            Storage::disk('bank_data')->delete($instruktur->sk_jabatan['file']);
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

        $instruktur->delete();
        $instruktur->user()->delete();

        return $instruktur;
    }
}
