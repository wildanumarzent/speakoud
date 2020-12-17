<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KodeEvaluasiInstrukturRequest extends FormRequest
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
            'kode_evaluasi' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'kode_evaluasi' => 'Kode Evaluasi',
        ];
    }

    public function messages()
    {
        return [
            'kode_evaluasi.required' => ':attribute tidak boleh kosong',
        ];
    }
}
