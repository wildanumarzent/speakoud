<?php

namespace App\Services\Users;

use App\Models\Users\Mitra;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class MitraService
{
    private $model, $user;

    public function __construct(
        Mitra $model,
        UserService $user
    )
    {
        $this->model = $model;
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
        $this->setField($request, $mitra);
        $mitra->save();

        $user->userable()->associate($mitra);
        $user->save();

        return [
            'user' => $user,
            'mitra' => $mitra
        ];
    }

    public function updateMitra($request, int $userId)
    {
        $mitra = $this->findMitra($userId);
        $this->setField($request, $mitra);
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

    public function setField($request, $mitra)
    {
        $mitra->nip = $request->nip ?? null;
        $mitra->instansi_id = $request->instansi_id ?? null;
        $mitra->kedeputian = $request->kedeputian ?? null;
        $mitra->pangkat = $request->pangkat ?? null;
        $mitra->alamat = $request->alamat ?? null;
        $mitra->sk_cpns = $request->sk_cpns ?? null;
        $mitra->sk_pengangkatan = $request->sk_pengangkatan ?? null;
        $mitra->sk_golongan = $request->sk_golongan ?? null;
        $mitra->sk_jabatan = $request->sk_jabatan ?? null;

        return $mitra;
    }

    public function deleteMitra(int $id)
    {
        $mitra = $this->findMitra($id);
        $user = $mitra->user;

        if ($user->information()->count() > 0) {
            $user->information()->delete();
        }
        if (!empty($user->photo['file'])) {
            $path = public_path('userfile/photo/'.$user->photo['file']) ;
            File::delete($path);
        }

        $mitra->delete();
        $mitra->user()->delete();

        return $mitra;
    }
}
