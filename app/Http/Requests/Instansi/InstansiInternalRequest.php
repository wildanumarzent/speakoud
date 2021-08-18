<?php

namespace App\Http\Requests\Instansi;

use Illuminate\Foundation\Http\FormRequest;

class InstansiInternalRequest extends FormRequest
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
        if ($this->method() == 'POST') {

            return [
                'kode_instansi' => 'required|unique:instansi_internal,kode_instansi',
                'nip_pimpinan' => 'required',
                'nama_pimpinan' => 'required',
                'nama_instansi' => 'required',
                'jabatan' => 'required',
                'logo' => 'nullable|mimes:'.config('custom.files.logo_instansi.m'),
            ];

        } else {

            return [
                'kode_instansi' => 'required|unique:instansi_internal,kode_instansi,'
                    .$this->id,
                'nip_pimpinan' => 'required',
                'nama_pimpinan' => 'required',
                'nama_instansi' => 'required',
                'jabatan' => 'required',
                'logo' => 'nullable|mimes:'.config('custom.files.logo_instansi.m'),
            ];

        }
    }

    public function attributes()
    {
        return [
            'kode_instansi' => 'Kode Instansi',
            'nip_pimpinan' => 'NIP',
            'nama_pimpinan' => 'Nama Pimpinan',
            'nama_instansi' => 'Nama Instansi',
            'jabatan' => 'Jabatan',
            'logo' => 'Logo',
        ];
    }

    public function messages()
    {
        return [
            'kode_instansi.required' => ':attribute tidak boleh kosong',
            'kode_instansi.unique' => ':attribute sudah terpakai',
            'nip_pimpinan.required' => ':attribute tidak boleh kosong',
            'nama_pimpinan.required' => ':attribute tidak boleh kosong',
            'nama_instansi.required' => ':attribute tidak boleh kosong',
            'jabatan.required' => ':attribute tidak boleh kosong',
            'logo.mimes' => 'Tipe :attribute harus :values.',
        ];
    }
}