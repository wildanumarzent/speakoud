<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetInstrukturRequest extends FormRequest
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
            'instruktur_id.*' => 'required',

        ];

    }

    // public function attributes()
    // {
    //     return [
    //         'instruktur_id.*' => 'Instruktur',
    //     ];
    // }

    public function messages()
    {
        return [
            'instruktur_id.*.required' => 'Instruktur harus dipilih',
        ];
    }
}
