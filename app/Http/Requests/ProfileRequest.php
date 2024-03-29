<?php

namespace App\Http\Requests;

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
                'file' => 'nullable|mimes:'.config('addon.mimes.photo.m')
            ];
        } else {
            return [
                'name' => 'required|min:5',
                'email' => 'required|email|unique:users,email,'.
                            auth()->user()->id,
                'username' => 'required|unique:users,username,'.
                            auth()->user()->id,
                'file' => 'nullable|mimes:'.config('addon.mimes.photo.m')
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
            'file' => 'Photo'
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
        ];
    }
}
