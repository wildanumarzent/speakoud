<?php

namespace App\Http\Requests\Grades;

use Illuminate\Foundation\Http\FormRequest;

class GradesNilaiRequest extends FormRequest
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
            'minimum' => 'required',
            'maksimum' => 'required',
            'keterangan' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'minimum' => 'Nilai Minimum',
            'maksimum' => 'Nilai Maksimum',
            'keterangan' => 'Keterangan',
        ];
    }

    public function messages()
    {
        return [
            'minimum.required' => ':attribute tidak boleh kosong',
            'maksimum.required' => ':attribute tidak boleh kosong',
            'keterangan.required' => ':attribute tidak boleh kosong',
        ];
    }
}
