<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SertifikatExternalRequest extends FormRequest
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
            'sertifikat' => 'required|mimes:'.config('addon.mimes.sertifikat.m'),
        ];
    }

    public function attributes()
    {
        return [
            'sertifikat' => 'Sertifikat',
        ];
    }

    public function messages()
    {
        return [
            'sertifikat.required' => ':attribute tidak boleh kosong',
            'sertifikat.mimes' => 'Tipe :attribute harus :values.',
        ];
    }
}
