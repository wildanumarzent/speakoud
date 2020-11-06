<?php

namespace App\Services\Users;

use App\Models\BankData;
use App\Models\Users\Internal;
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
        $this->setField($request, $internal);
        $internal->save();

        $user->userable()->associate($internal);
        $user->save();

        return [
            'user' => $user,
            'internal' => $internal
        ];
    }

    public function updateInternal($request, int $userId)
    {
        $internal = $this->findInternal($userId);
        $this->setField($request, $internal);
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

        return [
            'internal' => $internal,
            'user' => $user
        ];
    }

    public function setField($request, $internal)
    {
        $internal->nip = $request->nip ?? null;
        $internal->instansi_id = $request->instansi_id;
        $internal->kedeputian = $request->kedeputian ?? null;
        $internal->pangkat = $request->pangkat ?? null;
        $internal->alamat = $request->alamat ?? null;

        return $internal;
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
