<?php

namespace App\Services\Users;

use App\Models\Users\Peserta;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class PesertaService
{
    private $model, $user;

    public function __construct(
        Peserta $model,
        UserService $user
    )
    {
        $this->model = $model;
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

    public function findPeserta(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storePeserta($request)
    {
        $user = $this->user->storeUser($request);

        $peserta = new Peserta;
        $peserta->user_id = $user->id;
        $peserta->creator_id = auth()->user()->id;
        $peserta->mitra_id = $request->mitra_id ?? null;
        $this->setField($request, $peserta);
        $peserta->save();

        $user->userable()->associate($peserta);
        $user->save();

        return [
            'user' => $user,
            'peserta' => $peserta
        ];
    }

    public function updatePeserta($request, int $userId)
    {
        $peserta = $this->findPeserta($userId);
        $this->setField($request, $peserta);
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

        return [
            'peserta' => $peserta,
            'user' => $user
        ];
    }

    public function setField($request, $peserta)
    {
        $peserta->nip = $request->nip ?? null;
        $peserta->unit_kerja = $request->unit_kerja ?? null;
        $peserta->kedeputian = $request->kedeputian ?? null;
        $peserta->pangkat = $request->pangkat ?? null;
        $peserta->alamat = $request->alamat ?? null;
        $peserta->sk_cpns = $request->sk_cpns ?? null;
        $peserta->sk_pengangkatan = $request->sk_pengangkatan ?? null;
        $peserta->sk_golongan = $request->sk_golongan ?? null;
        $peserta->sk_jabatan = $request->sk_jabatan ?? null;
        $peserta->surat_ijin_atasan = $request->surat_ijin_atasan ?? null;

        return $peserta;
    }

    public function deletePeserta(int $id)
    {
        $peserta = $this->findPeserta($id);
        $user = $peserta->user;

        if ($user->information()->count() > 0) {
            $user->information()->delete();
        }
        if (!empty($user->photo['file'])) {
            $path = public_path('userfile/photo/'.$user->photo['file']) ;
            File::delete($path);
        }

        $peserta->delete();
        $peserta->user()->delete();

        return $peserta;
    }
}
