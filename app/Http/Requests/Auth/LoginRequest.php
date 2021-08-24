<?php

namespace App\Http\Requests\Auth;

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
        // dd($this->loginType().', active,1');
        return [
            // 'username' => 'required|string|min:5
            //             |exists:users,'.$this->loginType().',active,1',
            'email' => 'required|string
                        |exists:users',
            'password' => 'required|string|min:8',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email',
            'password' => 'Password'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => ':attribute tidak boleh kosong',
            'email.exists' => 'Akun yang coba anda masukan tidak '.
                                'terdaftar / tidak aktif',
            // 'username.min' => ':attribute minimal :min karakter',
            'password.required' => ':attribute tidak boleh kosong',
            'password.min' => ':attribute minimal :min karakter',
        ];
    }

    public function forms()
    {
        return [
            $this->loginType() => $this->email,
            'password' => $this->password,
        ];
    }

    private function loginType()
    {

        $loginType = filter_var($this->email, FILTER_VALIDATE_EMAIL) ?
                    'email' : 'username';
        // dd($loginType);

        return $loginType;
    }
}
