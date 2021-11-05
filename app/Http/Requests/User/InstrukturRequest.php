<?php

namespace App\Http\Requests\User;

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
                    'password' => 'nullable|confirmed|min:8',
                    'gender' => 'required',
                    'pendidikan' => 'required',
                    'phone' => 'required',
                    'address' => 'required',
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
                'pendidikan' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'date_of_birthday' => 'required',
            ];
        }
    }

    public function attributes()
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'username' => 'User name',
            'password' => 'password',
            'gender' => 'Jenis kelamin',
            'pendidikan' => 'Pendidikan',
            'phone' => 'Phone',
            'address' => 'alamat',
            'date_of_brithday' => 'Tanggal lahir',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute tidak boleh kosong',
            'email.unique' => ':attribute sudah terpakai',
            'username.required' => ':attribute tidak boleh kosong',
            'password.required' => ':attribute tidak boleh kosong',
            'gender.required' => ':attribute tidak boleh kosong',
            'pendidikakan.required' => ':attribute tidak boleh kosong',
            'phone.required' => ':attribute tidak boleh kosong',
            'address.required' => ':attribute tidak boleh kosong',
            'date_of_brithday.required' => ':attribute harus Di isi',
        ];
    }
}
