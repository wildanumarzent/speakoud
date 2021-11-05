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

            if (auth()->user()->hasRole('developer|administrator')) {

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
                    'email' => 'required|email|unique:users,email',auth()->user()->id,
                    'username' => 'required|min:5|unique:users,username',auth()->user()->id,
                    'password' => 'required|confirmed|min:8',
                    'gender' => 'required',
                    'phone' => 'required',
                    'address' => 'required',
                    'place_of_brithday' => 'required',
                    'date_of_brithday' => 'required',
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
                'gender' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'date_of_brithday' => 'required',
            ];
        }

    }

    public function attributes()
    {
        return [
            'alamat' => 'Alamat',
            'name' => 'Nama',
            'email' => 'Email',
            'username' => 'Username',
            'roles' => 'Roles',
            'password' => 'Password',
            'date_of_brithday' => 'tanggal lahir',
            'address' => 'alamat'
        ];
    }

    public function messages()
    {
        return [
            'alamat.required' => ':attribute tidak boleh kosong',
            'name.required' => ':attribute tidak boleh kosong',
            'email.required' => ':attribute tidak boleh kosong',
            'email.email' => ':attribute harus valid',
            'email.unique' => ':attribute sudah terpakai',
            'username.required' => ':attribute tidak boleh kosong',
            'username.min' => ':attribute minimal :min karakter',
            'username.unique' => ':attribute sudah terpakai',
            'password.required' => ':attribute tidak boleh kosong',
            'password.confirmed' => 'Konfirmasi password tidak sama dengan '.
                                    'password',
            'password.min' => ':attribute minimal :min karakter',
        ];
    }
}
