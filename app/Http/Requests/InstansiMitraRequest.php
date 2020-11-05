<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstansiMitraRequest extends FormRequest
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
            'nama_pimpinan' => 'required',
            'nama_instansi' => 'required',
            'jabatan' => 'required',
            'logo' => 'nullable|mimes:'.config('addon.mimes.logo_instansi.m'),
        ];

    }

    public function attributes()
    {
        return [
            'nama_pimpinan' => 'Nama Pimpinan',
            'nama_instansi' => 'Instansi',
            'jabatan' => 'Jabatan',
            'logo' => 'Logo',
        ];
    }

    public function messages()
    {
        return [
            'nama_pimpinan.required' => ':attribute tidak boleh kosong',
            'nama_instansi.required' => ':attribute tidak boleh kosong',
            'jabatan.required' => ':attribute tidak boleh kosong',
            'logo.mimes' => 'Tipe :attribute harus :values.',
        ];
    }
}
