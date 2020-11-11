<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MitraRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method() == 'POST') {
            return [
                'nip' => 'required',
                'instansi_id' => 'required',
                'kedeputian' => 'required',
                // 'pangkat' => 'required',
                // 'alamat' => 'required',
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'username' => 'required|min:5|unique:users,username',
                'roles' => 'required',
                'password' => 'required|confirmed|min:8',
                'sk_cpns' => 'nullable|mimes:'.config('addon.mimes.surat_keterangan.m'),
                'sk_pengangkatan' => 'nullable|mimes:'.config('addon.mimes.surat_keterangan.m'),
                'sk_golongan' => 'nullable|mimes:'.config('addon.mimes.surat_keterangan.m'),
                'sk_jabatan' => 'nullable|mimes:'.config('addon.mimes.surat_keterangan.m'),
            ];
        } else {
            return [
                'nip' => 'required',
                'instansi_id' => 'required',
                'kedeputian' => 'required',
                // 'pangkat' => 'required',
                // 'alamat' => 'required',
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.
                            $this->user_id,
                'username' => 'required|min:5|unique:users,username,'.
                            $this->user_id,
                'password' => 'nullable|confirmed|min:8',
                'sk_cpns' => 'nullable|mimes:'.config('addon.mimes.surat_keterangan.m'),
                'sk_pengangkatan' => 'nullable|mimes:'.config('addon.mimes.surat_keterangan.m'),
                'sk_golongan' => 'nullable|mimes:'.config('addon.mimes.surat_keterangan.m'),
                'sk_jabatan' => 'nullable|mimes:'.config('addon.mimes.surat_keterangan.m'),
            ];
        }

    }

    public function attributes()
    {
        return [
            'nip' => 'NIP',
            'instansi_id' => 'Unit Kerja',
            'kedeputian' => 'Kedeputian',
            'pangkat' => 'Pangkat',
            'alamat' => 'Alamat',
            'name' => 'Nama',
            'email' => 'Email',
            'username' => 'Username',
            'roles' => 'Roles',
            'password' => 'Password',
            'sk_cpns' => 'Surat Keterangan CPNS',
            'sk_pengankatan' => 'Surat Keterangan Pengangkatan',
            'sk_golongan' => 'Surat Keterangan Golongan',
            'sk_jabatan' => 'Surat Keterangan Jabatan',
        ];
    }

    public function messages()
    {
        return [
            'nip.required' => ':attribute tidak boleh kosong',
            'instansi_id.required' => ':attribute tidak boleh kosong',
            'kedeputian.required' => ':attribute tidak boleh kosong',
            'pangkat.required' => ':attribute tidak boleh kosong',
            'alamat.required' => ':attribute tidak boleh kosong',
            'name.required' => ':attribute tidak boleh kosong',
            'email.required' => ':attribute tidak boleh kosong',
            'email.email' => ':attribute harus valid',
            'email.unique' => ':attribute sudah terpakai',
            'username.required' => ':attribute tidak boleh kosong',
            'username.min' => ':attribute minimal :min karakter',
            'username.unique' => ':attribute sudah terpakai',
            'roles.required' => ':attribute tidak boleh kosong',
            'password.required' => ':attribute tidak boleh kosong',
            'password.confirmed' => 'Konfirmasi password tidak sama dengan '.
                                    'password',
            'password.min' => ':attribute minimal :min karakter',
            'sk_cpns.mimes' => 'Tipe :attribute harus :values.',
            'sk_pengankatan.mimes' => 'Tipe :attribute harus :values.',
            'sk_golongan.mimes' => 'Tipe :attribute harus :values.',
            'sk_jabatan.mimes' => 'Tipe :attribute harus :values.',
        ];
    }
}
