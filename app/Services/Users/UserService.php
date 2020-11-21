<?php

namespace App\Services\Users;

use App\Models\BankData;
use App\Models\Users\User;
use App\Models\Users\UserInformation;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    private $model, $modelBankData, $modelInformation;

    public function __construct(
        User $model,
        BankData $modelBankData,
        UserInformation $modelInformation
    )
    {
        $this->model = $model;
        $this->modelBankData = $modelBankData;
        $this->modelInformation = $modelInformation;
    }

    public function getUserList($request)
    {
        $query = $this->model->query();

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

        $result = $query->orderBy('id', 'ASC')->paginate(20);

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
        $user = new User($request->only(['name', 'email', 'username']));
        $user->password = Hash::make($request->password);
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
        $information->general = [
            'city' => $request->city ?? null,
            'description' => $request->description ?? null,
        ];
        $information->additional_name = [
            'first_name' => $request->first_name ?? null,
            'sur_name' => $request->sur_name ?? null,
            'middle_name' => $request->middle_name ?? null,
            'alternate_name' => $request->alternate_name ?? null,
        ];
        $information->optional = [
            'web_page' => $request->web_page ?? null,
            'icq_number' => $request->icq_number ?? null,
            'skype_id' => $request->skype_id ?? null,
            'aim_id' => $request->aim_id ?? null,
            'yahoo_id' => $request->yahoo_id ?? null,
            'msn_id' => $request->msn_id ?? null,
            'id_number' => $request->id_number ?? null,
            'institution' => $request->institution ?? null,
            'departement' => $request->departement ?? null,
            'phone' => $request->phone ?? null,
            'mobile_phone' => $request->mobile_phone ?? null,
            'address' => $request->address ?? null,
        ];
        $information->save();

        return $information;
    }

    public function updateUser($request, int $id)
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
        $user->assignRole($request->roles);
        $user->save();

        return $user;
    }

    public function updateInformation($request, int $userId)
    {
        $information = $this->findUser($userId)->information;
        $information->general = [
            'city' => $request->city ?? null,
            'description' => $request->description ?? null,
        ];
        $information->additional_name = [
            'first_name' => $request->first_name ?? null,
            'sur_name' => $request->sur_name ?? null,
            'middle_name' => $request->middle_name ?? null,
            'alternate_name' => $request->alternate_name ?? null,
        ];
        $information->optional = [
            'web_page' => $request->web_page ?? null,
            'icq_number' => $request->icq_number ?? null,
            'skype_id' => $request->skype_id ?? null,
            'aim_id' => $request->aim_id ?? null,
            'yahoo_id' => $request->yahoo_id ?? null,
            'msn_id' => $request->msn_id ?? null,
            'id_number' => $request->id_number ?? null,
            'institution' => $request->institution ?? null,
            'departement' => $request->departement ?? null,
            'phone' => $request->phone ?? null,
            'mobile_phone' => $request->mobile_phone ?? null,
            'address' => $request->address ?? null,
        ];
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
            $this->deletePhotoFromPath($request->old_photo);
            $request->file('file')->move(public_path('userfile/photo'), $fileName);
        }
        $user->photo = [
            'filename' => ($request->file != null) ? $fileName : $user->photo['filename'],
            'description' => $request->photo_description ?? null,
        ];
        $user->save();

        $this->updateInformation($request, $id);

        return $user;
    }

    public function deleteUser(int $id)
    {
        $user = $this->findUser($id);
        $bankData = $this->modelBankData->where('owner_id', $id);

        if ($user->information()->count() > 0) {
            $user->information()->delete();
        }

        if (!empty($user->photo['filename'])) {
            $this->deletePhotoFromPath($user->photo['filename']);
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

        if ($user->hasRole('internal')) {
            $user->internal()->delete();
        }

        if ($user->hasRole('mitra')) {
            $user->mitra()->delete();
        }

        if ($user->hasRole('instruktur_internal|instruktur_mitra')) {
            $user->instruktur()->delete();
        }

        if ($user->hasRole('peserta_internal|peserta_mitra')) {
            $user->peserta()->delete();
        }

        $user->delete();

        if ($user->hasRole('developer|administrator')) {
            return $user;
        } else {
            return false;
        }
    }

    public function deletePhotoFromPath($fileName)
    {
        $path = public_path('userfile/photo/'.$fileName) ;
        File::delete($path);

        return $path;
    }
}
