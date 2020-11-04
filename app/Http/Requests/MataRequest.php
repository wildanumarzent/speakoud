<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MataRequest extends FormRequest
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
            'judul' => 'required',
            'publish_start' => 'required',
            'cover' => 'nullable|mimes:'.config('addon.mimes.cover.m'),
        ];

    }

    public function attributes()
    {
        return [
            'judul' => 'Judul',
            'publish_start' => 'Publish Start',
            'cover' => 'Cover'
        ];
    }

    public function messages()
    {
        return [
            'judul.required' => ':attribute tidak boleh kosong',
            'publish_start.required' => ':attribute tidak boleh kosong',
            'cover.mimes' => 'Tipe :attribute harus :values.',
        ];
    }
}
