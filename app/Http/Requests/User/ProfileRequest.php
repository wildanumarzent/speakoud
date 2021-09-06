<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        if ($this->password != '') {

            return [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.
                            auth()->user()->id,
                'username' => 'required|min:5|unique:users,username,'.
                            auth()->user()->id,
                'current_password' => 'required|min:8',
                'password' => 'nullable|confirmed|min:8',
                'file' => 'nullable|mimes:'.config('custom.files.photo.m'),
                'foto_sertifikat' => 'nullable|mimes:'.config('custom.files.photo.m'),
                'tanggal_lahir' => 'required',
                'jenis_kelamin' => 'required',
                'tempat_lahir' => 'required',
                'no_hp' => 'required',
                'kota_tinggal' => 'required',
                'pekerjaan' => 'required',
                'pendidikan' => 'required',
            ];

        } else {

            return [
                'name' => 'required|min:5',
                'email' => 'required|email|unique:users,email,'.
                            auth()->user()->id,
                'username' => 'required|unique:users,username,'.
                            auth()->user()->id,
                'file' => 'nullable|mimes:'.config('custom.files.photo.m'),
                'foto_sertifikat' => 'nullable|mimes:'.config('custom.files.photo.m'),
                'tanggal_lahir' => 'required',
                'jenis_kelamin' => 'required',
                'tempat_lahir' => 'required',
                'no_hp' => 'required',
                'kota_tinggal' => 'required',
                'pekerjaan' => 'required',
                'pendidikan' => 'required',
            ];

        }
    }

    public function attributes()
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'username' => 'Username',
            'current_password' => 'Current Password',
            'password' => 'Password',
            'file' => 'Photo',
            'foto_sertifikat' => 'Foto Sertifikat',
            'jenis_kelamin' => 'jenis kelamin',
            'tempat_lahir' => 'tempat lahir',
            'no_hp' => 'phone',
            'kota_tinggal' => 'kota tinggal',
            'tanggal_lahir' => 'tanggal lahir',
            'pekerjaan' => 'pekerjaan',
            'pendidikan' => 'pendidikan',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute tidak boleh kosong',
            'email.required' => ':attribute tidak boleh kosong',
            'email.email' => ':attribute harus valid',
            'email.unique' => ':attribute sudah terpakai',
            'username.required' => ':attribute tidak boleh kosong',
            'username.min' => ':attribute minimal :min karakter',
            'username.unique' => ':attribute sudah terpakai',
            'current_password.required' => ':attribute tidak boleh kosong',
            'current_password.min' => ':attribute minimal :min karakter',
            'password.confirmed' => 'Konfirmasi password tidak sama dengan '.
                                    'password',
            'password.min' => ':attribute minimal :min karakter',
            'file.mimes' => 'Tipe :attribute harus :values.',
            'foto_sertifikat.mimes' => 'Tipe :attribute harus :values.',
            'jenis_kelamin.required' => ':attribute tidak boleh kosong',
            'tempat_lahir.required' => ':attribute tidak boleh kosong',
            'no_hp.required' => ':attribute tidak boleh kosong',
            'kota_tinggal.required' => ':attribute tidak boleh kosong',
            'tanggal_lahir.required' => ':attribute tidak boleh kosong',
            'pendidikan.required' => ':attribute tidak boleh kosong',
            'pekerjaan.required' => ':attribute tidak boleh kosong',
        ];
    }
}
