<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstrukturRequest extends FormRequest
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
            if (auth()->user()->hasRole('developer|administrator') && $this->roles == 'instruktur_mitra') {
                return [
                    'nip' => 'required',
                    'unit_kerja' => 'required',
                    'kedeputian' => 'required',
                    // 'pangkat' => 'required',
                    // 'alamat' => 'required',
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'username' => 'required|min:5|unique:users,username',
                    'roles' => 'required',
                    'mitra_id' => 'required',
                    'password' => 'required|confirmed|min:8',
                ];
            } else {
                return [
                    'nip' => 'required',
                    'unit_kerja' => 'required',
                    'kedeputian' => 'required',
                    // 'pangkat' => 'required',
                    // 'alamat' => 'required',
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'username' => 'required|min:5|unique:users,username',
                    'roles' => 'required',
                    'password' => 'required|confirmed|min:8',
                ];
            }
        } else {
            return [
                'nip' => 'required',
                'unit_kerja' => 'required',
                'kedeputian' => 'required',
                // 'pangkat' => 'required',
                // 'alamat' => 'required',
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
            'nip' => 'NIP',
            'unit_kerja' => 'Unit Kerja',
            'kedeputian' => 'Kedeputian',
            'pangkat' => 'Pangkat',
            'alamat' => 'Alamat',
            'name' => 'Nama',
            'email' => 'Email',
            'username' => 'Username',
            'roles' => 'Roles',
            'mitra_id' => 'Mitra',
            'password' => 'Password',
        ];
    }

    public function messages()
    {
        return [
            'nip.required' => ':attribute tidak boleh kosong',
            'unit_kerja.required' => ':attribute tidak boleh kosong',
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
        ];
    }
}
