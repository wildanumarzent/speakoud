<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
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
                'file_path' => 'required|mimes:'.config('addon.mimes.bank_data.m')
            ];
        } else {
            return [
                'thumbnail' => 'nullable|mimes:'.config('addon.mimes.photo.m'),
                'filename' => 'required',
            ];
        }

    }

    public function attributes()
    {
        return [
            'file_path' => 'File',
            'thumbnail' => 'Thumbnail',
            'filename' => 'Filename'
        ];
    }

    public function messages()
    {
        return [
            'file_path.required' => ':attribute tidak boleh kosong',
            'filename.required' => ':attribute tidak boleh kosong',
            'thumbnail.required' => ':attribute tidak boleh kosong',
            'file_path.mimes' => 'Tipe :attribute harus :values.',
            'thumbnail.mimes' => 'Tipe :attribute harus :values.',
        ];
    }
}
