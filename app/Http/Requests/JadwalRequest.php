<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JadwalRequest extends FormRequest
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
            // 'mata_id' => 'required',
            'judul' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'cover_file' => 'nullable|mimes:'.config('addon.mimes.cover.m'),
        ];
    }

    public function attributes()
    {
        return [
            'mata_id' => 'Mata Pelatihan',
            'judul' => 'Judul',
            'start_date' => 'Tanggal Mulai',
            'end_date' => 'Tanggal Selesai',
            'start_time' => 'Jam Mulai',
            'end_time' => 'Jam Selesai',
            'cover_file' => 'Cover'
        ];
    }

    public function messages()
    {
        return [
            'mata_id.required' => ':attribute tidak boleh kosong',
            'judul.required' => ':attribute tidak boleh kosong',
            'start_date.required' => ':attribute tidak boleh kosong',
            'end_date.required' => ':attribute tidak boleh kosong',
            'start_time.required' => ':attribute tidak boleh kosong',
            'end_time.required' => ':attribute tidak boleh kosong',
            'cover_file.mimes' => 'Tipe :attribute harus :values.',
        ];
    }
}
