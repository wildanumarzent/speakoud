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
        $this->setField($request, $instruktur);
        $instruktur->save();

        $user->userable()->associate($instruktur);
        $user->save();

        return [
            'user' => $user,
            'instruktur' => $instruktur
        ];
    }

    public function updateInstruktur($request, int $userId)
    {
        $instruktur = $this->findInstruktur($userId);
        $this->setField($request, $instruktur);
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

    public function setField($request, $instruktur)
    {
        $instruktur->nip = $request->nip ?? null;
        $instruktur->unit_kerja = $request->unit_kerja ?? null;
        $instruktur->kedeputian = $request->kedeputian ?? null;
        $instruktur->pangkat = $request->pangkat ?? null;
        $instruktur->alamat = $request->alamat ?? null;
        $instruktur->sk_cpns = $request->sk_cpns ?? null;
        $instruktur->sk_pengangkatan = $request->sk_pengangkatan ?? null;
        $instruktur->sk_golongan = $request->sk_golongan ?? null;
        $instruktur->sk_jabatan = $request->sk_jabatan ?? null;

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
