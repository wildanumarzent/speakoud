<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GradesLetterRequest extends FormRequest
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
            'nilai_minimum' => 'required',
            'nilai_maksimum' => 'required',
            'angka' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'nilai_minimum' => 'Nilai Minimum',
            'nilai_maksimum' => 'Nilai Maksimum',
            'angka' => 'Angka',
        ];
    }

    public function messages()
    {
        return [
            'nilai_minimum.required' => ':attribute tidak boleh kosong',
            'nilai_maksimum.required' => ':attribute tidak boleh kosong',
            'angka.required' => ':attribute tidak boleh kosong',
        ];
    }
}
