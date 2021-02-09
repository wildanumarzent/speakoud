<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SertifikatInternalRequest extends FormRequest
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

            if ($this->tipe == 1) {
                return [
                    'nomor' => 'required|unique:sertifikat_internal,nomor',
                    'tanggal' => 'required',
                    'nama_pimpinan' => 'required',
                    'jabatan' => 'required',
                    'unit_kerja' => 'required',
                    'pejabat_terkait' => 'required',
                    'nama_pejabat' => 'required',
                    'tte' => 'nullable|mimes:'.config('addon.mimes.photo.m'),
                ];
            } else {
                return [
                    'nomor' => 'required|unique:sertifikat_internal,nomor',
                    'tanggal' => 'required',
                    'nama_pimpinan' => 'required',
                    'jabatan' => 'required',
                    'tte' => 'nullable|mimes:'.config('addon.mimes.photo.m'),
                ];
            }

        } else {

            if ($this->tipe == 1) {
                return [
                    'nomor' => 'required|unique:sertifikat_internal,nomor,'.$this->sertifikatId,
                    'tanggal' => 'required',
                    'nama_pimpinan' => 'required',
                    'jabatan' => 'required',
                    'unit_kerja' => 'required',
                    'pejabat_terkait' => 'required',
                    'nama_pejabat' => 'required',
                    'tte' => 'nullable|mimes:'.config('addon.mimes.photo.m'),
                ];
            } else {
                return [
                    'nomor' => 'required|unique:sertifikat_internal,nomor,'.$this->sertifikatId,
                    'tanggal' => 'required',
                    'nama_pimpinan' => 'required',
                    'jabatan' => 'required',
                    'tte' => 'nullable|mimes:'.config('addon.mimes.photo.m'),
                ];
            }
        }

    }

    public function attributes()
    {
        return [
            'nomor' => 'Nomor',
            'tanggal' => 'Tanggal Pengesahan',
            'nama_pimpinan' => 'Nama Pimpinan',
            'jabatan' => 'Jabatan',
            'unit_kerja' => 'Unit Kerja / Perusahaan ',
            'pejabat_terkait' => 'Pejabat Terkait',
            'nama_pejabat' => 'Nama Pejabat',
            'tte' => 'Tanda tangan elektronik',
        ];
    }

    public function messages()
    {
        return [
            'nomor.required' => ':attribute tidak boleh kosong',
            'nomor.unique' => ':attribute sudah terpakai',
            'tanggal.required' => ':attribute tidak boleh kosong',
            'nama_pimpinan.required' => ':attribute tidak boleh kosong',
            'jabatan.required' => ':attribute tidak boleh kosong',
            'unit_kerja.required' => ':attribute tidak boleh kosong',
            'pejabat_terkait.required' => ':attribute tidak boleh kosong',
            'nama_pejabat.required' => ':attribute tidak boleh kosong',
            'tte.mimes' => 'Tipe :attribute harus :values.',
        ];
    }
}
