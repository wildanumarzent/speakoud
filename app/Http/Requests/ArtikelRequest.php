<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArtikelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        if ($this->method() == 'POST') {
            return [
                'judul' => 'required',
                'slug' => 'required|unique:artikel,slug',
                'content' => 'required',
                'cover_file' => 'nullable|mimes:'.config('addon.mimes.cover.m'),
            ];
        } else {
            return [
                'judul' => 'required',
                'slug' => 'required|unique:artikel,slug,'. $this->id,
                'content' => 'required',
                'cover_file' => 'nullable|mimes:'.config('addon.mimes.cover.m'),
            ];
        }

    }

    public function attributes()
    {
        return [
            'judul' => 'Judul',
            'slug' => 'Slug',
            'content' => 'Content',
            'cover_file' => 'Cover'
        ];
    }

    public function messages()
    {
        return [
            'judul.required' => ':attribute tidak boleh kosong',
            'slug.required' => ':attribute tidak boleh kosong',
            'slug.unique' => ':attribute sudah terpakai',
            'content.required' => ':attribute tidak boleh kosong',
            'cover_file.mimes' => 'Tipe :attribute harus :values.',
        ];
    }
}
