<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class PesertaRequest extends FormRequest
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

            if (auth()->user()->hasRole('developer|administrator') && $this->roles == 'peserta_mitra') {

                return [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'username' => 'required|min:5|unique:users,username',
                    'roles' => 'required',
                    'password' => 'required|confirmed|min:8',
                ];

            } else {

                return [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'username' => 'required|min:5|unique:users,username',
                    // 'roles' => 'required',
                    'password' => 'required|confirmed|min:8',
                   
                    // 'foto_sertifikat' => 'nullable|mimes:'.config('addon.mimes.photo.m'),
                ];
            }
        } else {

            return [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.
                            $this->user_id,
                'username' => 'required|min:5|unique:users,username,'.
                            $this->user_id,
                'password' => 'nullable|confirmed|min:8',
            ];
        }

    }

    public function attributes()
    {
        return [
            'instansi_id' => 'Instansi / Perusahaan',
            'kedeputian' => 'Unit Kerja',
            'pangkat' => 'Jabatan',
            'alamat' => 'Alamat',
            'name' => 'Nama',
            'email' => 'Email',
            'username' => 'Username',
            'roles' => 'Roles',
            'mitra_id' => 'Mitra',
            'password' => 'Password',
            'sk_cpns' => 'Surat Keterangan CPNS',
            'sk_pengankatan' => 'Surat Keterangan Pengangkatan',
            'sk_golongan' => 'Surat Keterangan Golongan',
            'sk_jabatan' => 'Surat Keterangan Jabatan',
            'surat_ijin_atasan' => 'Surat Ijin Atasan',
            'foto_sertifikat' => 'Foto Sertifikat',
        ];
    }

    public function messages()
    {
        return [
            'nip.required' => ':attribute tidak boleh kosong',
            'nip.unique' => ':attribute sudah terpakai',
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
            'mitra_id.required' => ':attribute tidak boleh kosong',
            'password.required' => ':attribute tidak boleh kosong',
            'password.confirmed' => 'Konfirmasi password tidak sama dengan '.
                                    'password',
            'password.min' => ':attribute minimal :min karakter',
            'sk_cpns.mimes' => 'Tipe :attribute harus :values.',
            'sk_pengankatan.mimes' => 'Tipe :attribute harus :values.',
            'sk_golongan.mimes' => 'Tipe :attribute harus :values.',
            'sk_jabatan.mimes' => 'Tipe :attribute harus :values.',
            'surat_ijin_atasan.mimes' => 'Tipe :attribute harus :values.',
            'foto_sertifikat.mimes' => 'Tipe :attribute harus :values.',
        ];
    }
}
