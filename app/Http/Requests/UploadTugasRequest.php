<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadTugasRequest extends FormRequest
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
            // 'keterangan' => 'required',
            'files' => 'required|array',
            'files.*' => 'required|distinct|max:50000|mimes:'.config('addon.mimes.tugas.m'),
        ];
    }

    public function attributes()
    {
        return [
            'keterangan' => 'Keterangan',
            'files' => 'Files',
        ];
    }

    public function messages()
    {
        return [
            'keterangan.required' => ':attribute tidak boleh kosong',
            'files.required' => ':attribute tidak boleh kosong',
            'files.mimes' => 'Tipe :attribute harus :values.',
        ];
    }
}
