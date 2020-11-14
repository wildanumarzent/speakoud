<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
                'judul' => 'required',
                'slug' => 'required|unique:page,slug',
                'cover_file' => 'nullable|mimes:'.config('addon.mimes.cover.m'),
            ];
        } else {
            return [
                'judul' => 'required',
                'slug' => 'required|unique:page,slug,'. $this->id,
                'cover_file' => 'nullable|mimes:'.config('addon.mimes.cover.m'),
            ];
        }

    }

    public function attributes()
    {
        return [
            'judul' => 'Judul',
            'slug' => 'Slug',
            'cover_file' => 'Cover'
        ];
    }

    public function messages()
    {
        return [
            'judul.required' => ':attribute tidak boleh kosong',
            'slug.required' => ':attribute tidak boleh kosong',
            'slug.unique' => ':attribute sudah terpakai',
            'cover_file.mimes' => 'Tipe :attribute harus :values.',
        ];
    }
}
