<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
                'file' => 'required|mimes:'.config('addon.mimes.banner_default.m'),
                'judul' => 'required',
            ];
        } else {
            return [
                'file' => 'nullable|mimes:'.config('addon.mimes.banner_default.m'),
                'judul' => 'required',
            ];
        }
    }

    public function attributes()
    {
        return [
            'file' => 'File',
            'judul' => 'Judul',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => ':attribute tidak boleh kosong',
            'judul.required' => ':attribute tidak boleh kosong',
            'file.mimes' => 'Tipe :attribute harus :values.',
        ];
    }
}
