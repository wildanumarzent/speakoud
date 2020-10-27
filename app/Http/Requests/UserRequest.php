<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'username' => 'required|min:5|unique:users,username',
                'roles' => 'required',
                'password' => 'required|confirmed|min:8',
            ];
        } else {
            return [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.
                            $this->id,
                'username' => 'required|min:5|unique:users,username,'.
                            $this->id,
                'roles' => 'required',
                'password' => 'nullable|confirmed|min:8',
            ];
        }

    }

    public function attributes()
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'username' => 'Username',
            'roles' => 'Roles',
            'password' => 'Password',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute tidak boleh sama',
            'email.required' => ':attribute tidak boleh sama',
            'email.email' => ':attribute harus valid',
            'email.unique' => ':attribute sudah terpakai',
            'username.required' => ':attribute tidak boleh sama',
            'username.min' => ':attribute minimal :min karakter',
            'username.unique' => ':attribute sudah terpakai',
            'roles.required' => ':attribute tidak boleh sama',
            'password.required' => ':attribute tidak boleh sama',
            'password.confirmed' => 'Konfirmasi password tidak sama dengan '.
                                    'password',
            'password.min' => ':attribute minimal :min karakter',
        ];
    }
}
