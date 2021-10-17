<?php

namespace App\Services\Users;

use App\Models\BankData;
use App\Models\Course\MataInstruktur;
use App\Models\Users\Instruktur;
use App\Services\Course\ProgramService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Services\Users\PesertaService;
use App\Models\Course\PelatihanKhusus;
use App\Models\Users\Peserta;

class InstrukturService
{
    private $model, $modelBankData, $user, $program, $peserta, $pelatihanKhusus;

    public function __construct(
        Instruktur $model,
        BankData $modelBankData,
        UserService $user,
        ProgramService $program,
        Peserta $peserta,
        PelatihanKhusus $pelatihanKhusus
    )
    {
        $this->model = $model;
        $this->modelBankData = $modelBankData;
        $this->user = $user;
        $this->program = $program;
        $this->peserta = $peserta;
        $this->pelatihanKhusus = $pelatihanKhusus;
    }

    public function getInstrukturList($request)
    {
        $query = $this->model->query();

        $query->when($request->t, function ($query, $t) {
            $query->whereHas('user', function ($queryB) use ($t) {
                $queryB->whereHas('roles', function ($queryC) use ($t) {
                    $queryC->where('id', $t);
                });
            });
        })->when($request->q, function ($query, $q) {
            $query->where(function ($queryA) use ($q) {
                $queryA->whereHas('user', function (Builder $queryB) use ($q) {
                    $queryB->where('name', 'ilike', '%'.$q.'%')
                        ->orWhere('username', 'ilike', '%'.$q.'%');
                })->orWhere('nip', 'ilike', '%'.$q.'%')
                ->orWhere('kedeputian', 'ilike', '%'.$q.'%')
                ->orWhere('pangkat', 'ilike', '%'.$q.'%');
            });
        });

        if (Auth::user()->hasRole('internal')) {
            $query->whereHas('user', function ($queryC) {
                $queryC->whereHas('roles', function ($queryD) {
                    $queryD->where('name', 'instruktur_internal');
                });
            });
        }

        if (Auth::user()->hasRole('mitra')) {
            $query->where('mitra_id', Auth::user()->mitra->id);
            $query->whereHas('user', function ($queryE) {
                $queryE->whereHas('roles', function ($queryF) {
                    $queryF->where('name', 'instruktur_mitra');
                });
            });
        }

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->orderBy('id', 'ASC')->paginate($limit);

        return $result;
    }
     public function findInstrukturByUserId($id)
    {
        return $this->model->where('user_id', $id)->first();
    }
    public function getInstrukturByTypeProgram($programId)
    {
        $program = $this->program->findProgram($programId);

        $query = $this->model->query();

        $query->whereHas('user', function ($query) {
            $query->active();
        });

        if ($program->tipe == 0) {
            $query->whereNull('mitra_id');
        }

        if ($program->tipe == 1) {
            if (Auth::user()->hasRole('mitra')) {
                $query->where('mitra_id', Auth::user()->mitra->id);
            } else {
                $query->whereNotNull('mitra_id');
            }
        }

        $result = $query->get();

        return $result;
    }

    public function getInstrukturForMata($type, $instrukturId)
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

        $query->where(function ($query) use ($instrukturId) {
            $query->whereNotIn('id', $instrukturId);
        });

        $result = $query->get();

        return $result;
    }

    public function countInstruktur()
    {
        $query = $this->model->query();

        $query->whereHas('user', function ($query) {
            $query->active();
        });

        $result = $query->count();

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
        $instruktur->user_id =$user->id;
        $instruktur->creator_id = Auth::user()->id ?? $user->id;
        $instruktur->nama = $request->name;
        $instruktur->gender = $request->gender;
        $instruktur->pendidikan = $request->pendidikan;
        $instruktur->phone = $request->phone;
        $instruktur->ikut_pelatihan = $request->ikutPelatihan;
        // $instruktur->address = $request->address;
        $instruktur->tanggal_lahir = $request->tanggal_lahir;
        $this->uploadFile($request, $instruktur, $user->id, 'store');
        $instruktur->save();

        $user->userable()->associate($instruktur);
        $user->save();

        $pelatihanKhusus = new PelatihanKhusus;
        $pelatihanKhusus->instruktur_id = $instruktur->id;
        $pelatihanKhusus->mata_id = $request->mataId ?? null;
        $pelatihanKhusus->save();

        return [
            'user' => $user,
            'instruktur' => $instruktur,
            'pelatihanKhusus' => $pelatihanKhusus
        ];
    }

    public function updateInstruktur($request, int $id)
    {
        $instruktur = $this->findInstruktur($id);
        $instruktur->nip = $request->nip ?? null;
        $instruktur->instansi_id = $request->instansi_id ?? null;
        $instruktur->kedeputian = $request->kedeputian ?? null;
        $instruktur->pangkat = $request->pangkat ?? null;
        $instruktur->ikut_pelatihan = $request->ikutPelatihan;
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
        
        $this->user->updateInformation($request, $user->id);

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

        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            $cv = str_replace(' ', '-', $file->getClientOriginalName());

            Storage::disk('bank_data')->delete($request->old_cv);
            Storage::disk('bank_data')->put($path.$cv, file_get_contents($file));
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
        $instruktur->cv =  !empty($request->cv) ? $path.$cv : ($type == 'store' ? null : $find->cv);

        return $instruktur;
    }

    public function softDeleteInstruktur(int $id)
    {
        $checkProgram = MataInstruktur::where('instruktur_id', $id)->count();
        
        if ($checkProgram > 0) {

            return false;
        } else {
            $instruktur = $this->findInstruktur($id);
            $instruktur->user->delete();
            $instruktur->delete();

            return true;
        }
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

        if (!empty($instruktur->sk_golongan['file'])) {
            Storage::disk('bank_data')->delete($instruktur->sk_golongan['file']);
        }

        if (!empty($instruktur->sk_jabatan['file'])) {
            Storage::disk('bank_data')->delete($instruktur->sk_jabatan['file']);
        }

        if (!empty($instruktur->cv)) {
            Storage::disk('bank_data')->delete($instruktur->cv);
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

    public function RegisterInstruktur($request)
    {
        $user = $this->user->storeUser($request, 'register');
    }

    public function getMataKhusus(int $id)
    {
        return $this->pelatihanKhusus->with('pelatihan')->where('instruktur_id', $id)->get();
    }

    public function getPelatihanKhususInstruktur($instrukturId, $mataId)
    {
        return $this->pelatihanKhusus->with('pelatihan')
            ->where('mata_id', $mataId)->where('instruktur_id', $instrukturId)->first();
    }
    public function findPlatihanKhusus($id)
    {
        return $this->pelatihanKhusus->find($id);
    }
    public function giveAccess($id, $instrukturId)
    { 
        $give = $this->pelatihanKhusus->where('mata_id',$id)->where('instruktur_id', $instrukturId)->first();
        $give->is_access = 1;
        return $give->update();
    }
    public function MintaAkses($mataId, $instrukturId)
    {
        $pelatihanKhusus = new PelatihanKhusus;
        $pelatihanKhusus->instruktur_id = $instrukturId;
        $pelatihanKhusus->mata_id = $mataId;
        $dataAll = $pelatihanKhusus->save();
        return [
            'data' => $dataAll,
            'id_pelatihan_khusus' => $pelatihanKhusus->id
        ];
    }
}
