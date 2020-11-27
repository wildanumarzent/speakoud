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
            ];
        }
        if ($this->type == 'dokumen') {
            return [
                'judul' => 'required',
                'file_path' => 'required',
            ];
        }
        if ($this->type == 'conference') {
            if ($this->tipe == 1) {
                return [
                    'judul' => 'required',
                    'meeting_link' => 'required',
                ];
            } else {
                return [
                    'judul' => 'required',
                ];
            }
        }
        if ($this->type == 'quiz') {
            return [
                'judul' => 'required',
            ];
        }
        if ($this->type == 'scorm') {
            if ($this->method() == 'POST') {
                return [
                    'judul' => 'required',
                    'package' => 'required|mimes:'.config('addon.mimes.package_scorm.m'),
                ];
            } else {
                return [
                    'judul' => 'required',
                    'package' => 'nullable|mimes:'.config('addon.mimes.package_scorm.m'),
                ];
            }

        }
    }

    public function attributes()
    {
        return [
            'judul' => 'Judul',
            'tipe' => 'Tipe',
            'file_path' => 'File Path',
            'meeting_link' => 'Meeting Link',
            'package' => 'Package'
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
        ];
    }
}
