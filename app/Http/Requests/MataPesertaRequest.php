<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MataPesertaRequest extends FormRequest
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
            'peserta_id' => 'required',
        ];

    }

    public function attributes()
    {
        return [
            'peserta_id' => 'Peserta',
        ];
    }

    public function messages()
    {
        return [
            'peserta_id.required' => ':attribute harus dipilih',
        ];
    }
}
