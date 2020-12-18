<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BahanRequest extends FormRequest
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
        if ($this->type == 'forum') {
            return [
                'judul' => 'required',
                'tipe' => 'required',
                // 'publish_start' => 'required',
                // 'publish_end' => 'required',
            ];
        }
        if ($this->type == 'dokumen') {
            return [
                'judul' => 'required',
                'file_path' => 'required',
                // 'publish_start' => 'required',
                // 'publish_end' => 'required',
            ];
        }
        if ($this->type == 'conference') {
            if ($this->tipe == 1) {
                return [
                    'judul' => 'required',
                    'meeting_link' => 'required',
                    'tanggal' => 'required',
                    'start_time' => 'required',
                    'end_time' => 'required',
                    // 'publish_start' => 'required',
                    // 'publish_end' => 'required',
                ];
            } else {
                return [
                    'judul' => 'required',
                    'tanggal' => 'required',
                    'start_time' => 'required',
                    'end_time' => 'required',
                    // 'publish_start' => 'required',
                    // 'publish_end' => 'required',
                ];
            }
        }
        if ($this->type == 'quiz') {
            return [
                'judul' => 'required',
                'kategori' => 'required',
                // 'publish_start' => 'required',
                // 'publish_end' => 'required',
            ];
        }
        if ($this->type == 'scorm') {
            if ($this->method() == 'POST') {
                return [
                    'judul' => 'required',
                    'package' => 'required|mimes:'.config('addon.mimes.package_scorm.m'),
                    'repeatable' => 'nullable',
                    // 'publish_start' => 'required',
                    // 'publish_end' => 'required',
                ];
            } else {
                return [
                    'judul' => 'required',
                    'package' => 'nullable|mimes:'.config('addon.mimes.package_scorm.m'),
                    'repeatable' => 'nullable',
                    // 'publish_start' => 'required',
                    // 'publish_end' => 'required',
                ];
            }
        }
        if ($this->type == 'audio') {
            return [
                'judul' => 'required',
                'file_path' => 'required',
                // 'publish_start' => 'required',
                // 'publish_end' => 'required',
            ];
        }
        if ($this->type == 'video') {
            return [
                'judul' => 'required',
                'file_path' => 'required',
                // 'publish_start' => 'required',
                // 'publish_end' => 'required',
            ];
        }
        if ($this->type == 'tugas') {
            return [
                'judul' => 'required',
                'files' => 'required|array',
                'files.*' => 'required|max:50000|distinct|mimes:'.config('addon.mimes.tugas.m'),
                // 'publish_start' => 'required',
                // 'publish_end' => 'required',
            ];
        }
        if ($this->type == 'evaluasi-pengajar') {
            return [
                'judul' => 'required',
                'mata_instruktur_id' => 'required',
                // 'publish_start' => 'required',
                // 'publish_end' => 'required',
            ];
        }
    }

    public function attributes()
    {
        return [
            'judul' => 'Judul',
            'tipe' => 'Tipe',
            'file_path' => 'File Path',
            'meeting_link' => 'Meeting Link',
            'package' => 'Package',
            'files' => 'Files',
            'mata_instruktur_id' => 'Instruktur',
            'publish_start' => 'Tanggal Mulai',
            'publish_end' => 'Tanggal Selesai',
            'tanggal' => 'Tanggal',
            'start_time' => 'Jam Mulai',
            'end_time' => 'Jam Selesai',
            'kategori' => 'Kategori'
        ];
    }

    public function messages()
    {
        return [
            'judul.required' => ':attribute tidak boleh kosong',
            'tipe.required' => ':attribute tidak boleh kosong',
            'file_path.required' => ':attribute tidak boleh kosong',
            'meeting_link.required' => ':attribute tidak boleh kosong',
            'package.required' => ':attribute tidak boleh kosong',
            'package.mimes' => 'Tipe :attribute harus :values.',
            'files.required' => ':attribute tidak boleh kosong',
            'files.mimes' => 'Tipe :attribute harus :values.',
            'mata_instruktur_id.required' => ':attribute tidak boleh kosong',
            'publish_start.required' => ':attribute tidak boleh kosong',
            'publish_end.required' => ':attribute tidak boleh kosong',
            'tanggal.required' => ':attribute tidak boleh kosong',
            'start_time.required' => ':attribute tidak boleh kosong',
            'end_time.required' => ':attribute tidak boleh kosong',
            'kategori.required' => ':attribute tidak boleh kosong',
        ];
    }
}
