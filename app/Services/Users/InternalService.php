<?php

namespace App\Services\Users;

use App\Models\BankData;
use App\Models\Course\ProgramPelatihan;
use App\Models\Instansi\InstansiMitra;
use App\Models\Users\Instruktur;
use App\Models\Users\Internal;
use App\Models\Users\Mitra;
use App\Models\Users\Peserta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class InternalService
{
    private $model, $modelBankData, $user;

    public function __construct(
        Internal $model,
        BankData $modelBankData,
        UserService $user
    )
    {
        $this->model = $model;
        $this->modelBankData = $modelBankData;
        $this->user = $user;
    }

    public function getInternalList($request)
    {
        $query = $this->model->query();

        $query->when($request->j, function ($query, $j) {
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

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->orderBy('id', 'ASC')->paginate($limit);

        return $result;
    }

    public function countInternal()
    {
        $query = $this->model->query();
        $query->whereHas('user', function ($query) {
            $query->active();
        });
        
        $result = $query->count();
        // dd($query);

        return $result;
    }

    public function countUserAll()
    {
        $query= $this->user->getAllUser();
        $result = $query->count();
        return $result;
    }

    public function findInternal(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeInternal($request)
    {
        $user = $this->user->storeUser($request);

        $internal = new Internal;
        $internal->user_id = $user->id;
        $internal->creator_id = auth()->user()->id;
        $internal->nip = $request->nip ?? null;
        $internal->instansi_id = $request->instansi_id;
        $internal->kedeputian = $request->kedeputian ?? null;
        $internal->pangkat = $request->pangkat ?? null;
        $this->uploadFile($request, $internal, $user->id, 'store');
        $internal->save();

        $user->userable()->associate($internal);
        $user->save();

        return [
            'user' => $user,
            'internal' => $internal
        ];
    }

    public function updateInternal($request, int $id)
    {
        $internal = $this->findInternal($id);
        $internal->nip = $request->nip ?? null;
        $internal->instansi_id = $request->instansi_id;
        $internal->kedeputian = $request->kedeputian ?? null;
        $internal->pangkat = $request->pangkat ?? null;
        $this->uploadFile($request, $internal, $internal->user_id, 'update', $id);
        $internal->save();

        $user = $internal->user;
        $user->fill($request->only(['name', 'email', 'username']));

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->email != $request->old_email) {
            $user->email_verified = 0;
            $user->email_verified_at = null;
        }

        $user->save();
        
        $this->user->updateInformation($request, $user->id);

        return [
            'internal' => $internal,
            'user' => $user
        ];
    }

    public function uploadFile($request, $internal, $userId, $type, $id = null)
    {
        if ($id != null) {
            $find = $this->findInternal($id);
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

        $internal->sk_cpns = [
            'file' => !empty($request->sk_cpns) ? $path.$cpns : ($type == 'store' ? null : $find->sk_cpns['file']),
            'keterangan' => $request->keterangan_cpns ?? ($type == 'store' ? null : $find->sk_cpns['keterangan']),
        ];
        $internal->sk_pengangkatan = [
            'file' => !empty($request->sk_pengangkatan) ? $path.$pengangkatan : ($type == 'store' ? null : $find->sk_pengangkatan['file']),
            'keterangan' => $request->keterangan_pengangkatan ?? ($type == 'store' ? null : $find->sk_pengangkatan['keterangan']),
        ];
        $internal->sk_golongan = [
            'file' => !empty($request->sk_golongan) ? $path.$golongan : ($type == 'store' ? null : $find->sk_golongan['file']),
            'keterangan' => $request->keterangan_golongan ?? ($type == 'store' ? null : $find->sk_golongan['keterangan']),
        ];
        $internal->sk_jabatan = [
            'file' => !empty($request->sk_jabatan) ? $path.$jabatan : ($type == 'store' ? null : $find->sk_jabatan['file']),
            'keterangan' => $request->keterangan_jabatan ?? ($type == 'store' ? null : $find->sk_jabatan['keterangan']),
        ];

        return $internal;
    }

    public function softDeleteInternal(int $id)
    {
        $internal = $this->findInternal($id);
        $instansiMitra = InstansiMitra::where('creator_id', $internal->user_id)->count();
        $mitra = Mitra::where('creator_id', $internal->user_id)->count();
        $instruktur = Instruktur::where('creator_id', $internal->user_id)->count();
        $peserta = Peserta::where('creator_id', $internal->user_id)->count();
        $files = BankData::where('owner_id', $internal->user_id)->count();
        $program = ProgramPelatihan::where('creator_id', $internal->user_id)->count();

        if ($instansiMitra > 0 || $mitra > 0 || $instruktur > 0 || $peserta > 0 ||
            $files > 0 || $program > 0) {

            return false;
        } else {
            $internal->user->delete();
            $internal->delete();

            return true;
        }
    }

    public function deleteInternal(int $id)
    {
        $internal = $this->findInternal($id);
        $user = $internal->user;
        $bankData = $this->modelBankData->where('owner_id', $user->id);

        if ($user->information()->count() > 0) {
            $user->information()->delete();
        }

        if (!empty($user->photo['file'])) {
            $path = public_path('userfile/photo/'.$user->photo['file']) ;
            File::delete($path);
        }

        if (!empty($internal->sk_cpns['file'])) {
            Storage::disk('bank_data')->delete($internal->sk_cpns['file']);
        }

        if (!empty($internal->sk_pengangkatan['file'])) {
            Storage::disk('bank_data')->delete($internal->sk_pengangkatan['file']);
        }

        if (!empty($internal->sk_golongan['file'])) {
            Storage::disk('bank_data')->delete($internal->sk_golongan['file']);
        }

        if (!empty($internal->sk_jabatan['file'])) {
            Storage::disk('bank_data')->delete($internal->sk_jabatan['file']);
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

        $internal->delete();
        $internal->user()->delete();

        return $internal;
    }
}
