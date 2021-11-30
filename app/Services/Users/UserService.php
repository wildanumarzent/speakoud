<?php

namespace App\Services\Users;

use App\Models\BankData;
use App\Models\Course\ProgramPelatihan;
use App\Models\Instansi\InstansiInternal;
use App\Models\Instansi\InstansiMitra;
use App\Models\Users\Instruktur;
use App\Models\Users\Internal;
use App\Models\Users\Mitra;
use App\Models\Users\Peserta;
use App\Models\Users\User;
use App\Models\Course\MataPeserta;
use App\Models\Users\UserInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private $model, $mataPeserta;

    public function __construct(
        User $model,
        MataPeserta $mataPeserta
    )
    {
        $this->model = $model;
        $this->mataPeserta = $mataPeserta;
    }

    public function getAllUser()
    {
        $query = $this->model->query();

        $query->with('roles');

        $result = $query->orderBy('id', 'ASC')->get();

        return $result;
    }

    public function getUserList($request, $trash = false)
    {
        $query = $this->model->query();

        if ($trash == true) {
            $query->onlyTrashed();
        }

        $query->when($request->r, function ($query, $r) {
            return $query->whereHas('roles', function ($query) use ($r) {
                $query->where('id', $r);
            });
        })->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('name', 'like', '%'.$q.'%')
                ->orWhere('email', 'like', '%'.$q.'%')
                ->orWhere('username', 'like', '%'.$q.'%');
            });
        });

        if (isset($request->a)) {
            $query->where('active', $request->a);
        }

        $query->with('roles');

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->orderBy('id', 'ASC')->paginate($limit);

        return $result;
    }

    public function getEmailByRole(array $byRole = null)
    {
        $query = $this->model->query();

        if (!empty($byRole)) {
            $query->whereHas('roles', function ($query) use ($byRole) {
                $query->whereIn('id', $byRole);
            });
        }
        $query->active();
        $plucked = $query->pluck('email');
        $plucked->all();

        return $plucked;
    }

    public function findUser(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeUser($request, $isRegister = null)
    {
        $user = new User($request->only(['name', 'email']));
        $user->password = Hash::make($request->password);
        $user->username = $request->username ?? null;
        if (!empty($isRegister)) {
            $user->email_verified = 0;
            $user->email_verified_at = null;
            $user->active = 0;
            $user->active_at = null;
        } else {
            $user->active = 1;
            $user->active_at = now();
        }

        $user->photo = [
            'filename' => null,
            'description' => null,
        ];

        $user->assignRole($request->roles);
        $user->save();

        $this->storeInformation($request, $user->id);

        return $user;
    }

    public function storeInformation($request, int $userId)
    {
        $information = new UserInformation;
        $information->user_id = $userId;
        $information->place_of_birthday = $request->place_of_birthday ?? null;
        $information->date_of_birthday = $request->date_of_birthday ?? null;
        $information->gender = $request->gender ?? null;
        $information->city = $request->city ?? null;
        $information->description = $request->description ?? null;
        $information->phone = $request->phone ?? null;
        $information->address = $request->address ?? null;
        $information->pendidikan = $request->pendidikan ?? null;
        $information->save();

        return $information;
    }

    public function updateUser($request, int $id)
    {
        $request->all();
        $user = $this->findUser($id);
        $user->fill($request->only(['name', 'email', 'username']));

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->email != $request->old_email) {
            $user->email_verified = 0;
            $user->email_verified_at = null;
        }

        $user->assignRole($request->roles);
        $user->save();

        $this->updateInformation($request, $id);

        return $user;
    }

    public function updateInformation($request, int $userId)
    {
        $information = $this->findUser($userId)->information;
        $information->place_of_birthday = $request->place_of_birthday ?? null;
        $information->date_of_birthday = $request->date_of_birthday ?? null;
        $information->gender = $request->gender ?? null;
        $information->city = $request->city ?? null;
        $information->description = $request->description ?? null;
        $information->phone = $request->phone ?? null;
        $information->address = $request->address ?? null;
        $information->pendidikan = $request->pendidikan ?? null;
        $information->save();

        return $information;
    }

    public function activateUser(int $id)
    {
        $user = $this->findUser($id);
        $user->active = !$user->active;
        $user->active_at = $user->active == 1 ? now() : null;
        $user->save();

        return $user;
    }

    public function activateAccount($email)
    {
        $decrypt = Crypt::decrypt($email);

        $user = $this->model->where('email', $decrypt)->first();
        $user->email_verified = 1;
        $user->email_verified_at = now();
        $user->active = 1;
        $user->active_at = now();
        $user->save();

        return $user;
    }

    public function verificationEmail($email)
    {
        $decrypt = Crypt::decrypt($email);

        $user = $this->model->where('email', $decrypt)->first();
        $user->email_verified = 1;
        $user->email_verified_at = now();
        $user->save();

        return $user;
    }

    public function updateProfile($request, int $id)
    {
        
        $user = $this->findUser($id);
        $user->fill($request->only(['name', 'email', 'username']));

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->email != $request->old_email) {
            $user->email_verified = 0;
            $user->email_verified_at = null;
        }
        
        if ($request->hasFile('file')) {
            $fileName = str_replace(' ', '-', $request->file('file')
                ->getClientOriginalName());

            File::delete(public_path('userfile/photo/'.$request->old_photo));
            $request->file('file')->move(public_path('userfile/photo'), $fileName);
        }

        $user->photo = [
            'filename' => ($request->file != null) ? $fileName : $user->photo['filename'],
            'description' => $request->photo_description ?? null,
        ];

        $user->save();  

         if (Auth::user()->hasRole('administrator|developer')) {
               $information = new UserInformation;
                $information->user_id = Auth()->user()->id;
                $information->place_of_birthday = $request->place_of_birthday ?? null;
                $information->date_of_birthday = $request->date_of_birthday ?? null;
                $information->gender = $request->gender ?? null;
                $information->city = $request->city ?? null;
                $information->description = $request->description ?? null;
                $information->phone = $request->phone ?? null;
                $information->address = $request->address ?? null;
                $information->save();  
         }

        if (Auth::user()->hasRole('peserta_internal|peserta_mitra')) {

            if ($request->hasFile('foto_sertifikat')) {
                $fotoSertifikat = str_replace(' ', '-', $request->file('foto_sertifikat')
                    ->getClientOriginalName());
                $path = public_path('userfile/photo/'.$request->old_foto_sertifikat) ;
                File::delete($path);
                $request->file('foto_sertifikat')->move(public_path('userfile/photo/sertifikat'), $fotoSertifikat);
            }

            $peserta = $user->peserta;
            $peserta->jenis_kelamin = $request->jenis_kelamin ?? null;
            $peserta->agama = $request->agama ?? null;
            $peserta->tempat_lahir = $request->tempat_lahir ?? null;
            $peserta->tanggal_lahir = $request->tanggal_lahir ?? null;
            $peserta->jabatan_id = $request->jabatan_id ?? null;
            $peserta->no_hp = $request->no_hp ?? null;
            $peserta->pendidikan = $request->pendidikan ?? null;
            $peserta->pekerjaan = $request->pekerjaan ?? null;
            $peserta->kota_tinggal = $request->kota_tinggal ?? null;
            $peserta->Departemen = $request->departemen ?? null;
            $peserta->foto_sertifikat = ($request->foto_sertifikat != null) ? 
            $fotoSertifikat : $peserta->foto_sertifikat;


            if (!empty($request->gender) && !empty($request->place_of_birthday) &&
                !empty($request->date_of_birthday) && !empty($request->phone) &&
                !empty($request->name)) {
                $peserta->status_peserta = 1;
            } else {
                $peserta->status_peserta = 0;
            }

            $peserta->save();
        }

        $this->updateInformation($request, $id);

        return $user;
    }

    public function updateProfileFrontInstruktur($request, int $id)
    {
       
        $user = $this->findUser($id);
        $user->fill($request->only(['name', 'email', 'username']));

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->email != $request->old_email) {
            $user->email_verified = 0;
            $user->email_verified_at = null;
        }
        
        if ($request->hasFile('file')) {
            $fileName = str_replace(' ', '-', $request->file('file')
                ->getClientOriginalName());

            File::delete(public_path('userfile/photo/'.$request->old_photo));
            $request->file('file')->move(public_path('userfile/photo'), $fileName);
        }

        $user->photo = [
            'filename' => ($request->file != null) ? $fileName : $user->photo['filename'],
            'description' => $request->photo_description ?? null,
        ];

        $user->save();

       
        // dd($request->all()); 
        if (Auth::user()->hasRole('instruktur_internal')) {

            // $instruktur = new Instruktur();
            // if () {
            //     $instruktur->ikut_pelatihan = 1;
            // } else {
            //     $instruktur->ikut_pelatihan = 0;
            // }
            $instruktur = Instruktur::find($id);
            $instruktur->ikut_pelatihan = 1;
            $instruktur->save();
           
        }

        $this->updateInformation($request, $id);

        return $user;
    }

     public function updateProfileFront($request, int $id)
    {
        
        $user = $this->findUser($id);
        $user->fill($request->only(['name', 'email', 'username']));

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->email != $request->old_email) {
            $user->email_verified = 0;
            $user->email_verified_at = null;
        }
        
        if ($request->hasFile('file')) {
            $fileName = str_replace(' ', '-', $request->file('file')
                ->getClientOriginalName());

            File::delete(public_path('userfile/photo/'.$request->old_photo));
            $request->file('file')->move(public_path('userfile/photo'), $fileName);
        }

        $user->photo = [
            'filename' => ($request->file != null) ? $fileName : $user->photo['filename'],
            'description' => $request->photo_description ?? null,
        ];

        $user->save();

        if (Auth::user()->hasRole('peserta_internal|peserta_mitra')) {

            if ($request->hasFile('foto_sertifikat')) {
                $fotoSertifikat = str_replace(' ', '-', $request->file('foto_sertifikat')
                    ->getClientOriginalName());
                $path = public_path('userfile/photo/'.$request->old_foto_sertifikat) ;
                File::delete($path);
                $request->file('foto_sertifikat')->move(public_path('userfile/photo/sertifikat'), $fotoSertifikat);
            }

            $peserta = $user->peserta;
            $peserta->pekerjaan = $request->pekerjaan ?? null;
            $peserta->kota_tinggal = $request->kota_tinggal ?? null;
            
            if (!empty($request->place_of_birthday) && !empty($request->date_of_birthday) &&
                $request->phone >= 0  && $request->kota_tinggal >= 0 &&
                $request->gender >= 0  && !empty($request->pekerjaan) && !empty($request->pendidikan) ) {
                $peserta->status_peserta = 1;
            } else {
                $peserta->status_peserta = 0;
            }

            $peserta->save();
        }

        $this->updateInformation($request, $id);

        return $user;
    }

    public function softDeleteUser(int $id)
    {
        $instansiInternal = InstansiInternal::where('creator_id', $id)->count();
        $instansiMitra = InstansiMitra::where('creator_id', $id)->count();
        $internal = Internal::where('creator_id', $id)->count();
        $mitra = Mitra::where('creator_id', $id)->count();
        $instruktur = Instruktur::where('creator_id', $id)->count();
        $peserta = Peserta::where('creator_id', $id)->count();
        $files = BankData::where('owner_id', $id)->count();
        $program = ProgramPelatihan::where('creator_id', $id)->count();

        if ($instansiInternal > 0 || $instansiMitra > 0 || $internal > 0 ||
            $mitra > 0 || $instruktur > 0 || $peserta > 0 || $files > 0 ||
            $program > 0) {

            return false;
        } else {

            $user = $this->findUser($id);
            $user->delete();

            return true;
        }
    }

    public function restoreUser(int $id)
    {
        $user = $this->model->onlyTrashed()->where('id', $id);

        if ($user->first()->hasRole('internal')) {
            $user->first()->internal()->onlyTrashed()->restore();
        }

        if ($user->first()->hasRole('mitra')) {
            $user->first()->mitra()->onlyTrashed()->restore();
        }

        if ($user->first()->hasRole('instruktur_internal|instruktur_mitra')) {
            $user->first()->instruktur()->onlyTrashed()->restore();
        }

        if ($user->first()->hasRole('peserta_internal|peserta_mitra')) {
            $user->first()->peserta()->onlyTrashed()->restore();
        }

        $user->restore();

        return $user;
    }

    public function deleteUser(int $id)
    {
        $user = $this->model->onlyTrashed()->where('id', $id)->first();

        if ($user->information()->count() > 0) {
            $user->information()->delete();
        }

        if (!empty($user->photo['filename'])) {
            File::delete(public_path('userfile/photo/'.$user->photo['filename']));
        }

        if ($user->first()->hasRole('internal')) {
            $user->first()->internal()->forceDelete();
        }

        if ($user->first()->hasRole('mitra')) {
            $user->first()->mitra()->forceDelete();
        }

        if ($user->first()->hasRole('instruktur_internal|instruktur_mitra')) {
            $user->first()->instruktur()->forceDelete();
        }

        if ($user->first()->hasRole('peserta_internal|peserta_mitra')) {
            $user->first()->peserta()->forceDelete();
        }

        $user->forceDelete();

        return $user;
    }

    public function setMataPeserta($MataId, $pesertaId)
    {
       $enroll = MataPeserta::where('mata_id', $MataId)->where('peserta_id',$pesertaId)->get();
       if (count($enroll) == 0) {
            $mataPeserta = new MataPeserta;
            $mataPeserta->mata_id = $MataId;
            $mataPeserta->peserta_id = $pesertaId;
            return $mataPeserta->save();
       }else{
           return false;
       }
    }
}
