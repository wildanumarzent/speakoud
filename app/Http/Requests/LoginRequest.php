<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        return [
            'username' => 'required|string|min:5
                        |exists:users,'.$this->loginType().',active,1',
            'password' => 'required|string|min:8',
        ];
    }

    public function attributes()
    {
        return [
            'username' => 'Username',
            'password' => 'Password'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => ':attribute tidak boleh kosong',
            'username.exists' => 'Aku yang coba anda masukan tidak '.
                                'terdaftar / tidak aktif',
            'username.min' => ':attribute minimal :min karakter',
            'password.required' => ':attribute tidak boleh kosong',
            'password.min' => ':attribute minimal :min karakter',
        ];
    }

    public function forms()
    {
        return [
            $this->loginType() => $this->username,
            'password' => $this->password,
        ];
    }

    private function loginType()
    {

        $loginType = filter_var($this->username, FILTER_VALIDATE_EMAIL) ?
                    'email' : 'username';

        return $loginType;
    }
}
