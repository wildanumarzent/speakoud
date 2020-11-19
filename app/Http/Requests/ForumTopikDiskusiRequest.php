<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForumTopikDiskusiRequest extends FormRequest
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
            'message' => 'required',
            'attachment' => 'nullable|mimes:'.config('addon.mimes.attachment.m')
        ];
    }

    public function attributes()
    {
        return [
            'message' => 'Message',
            'attachment' => 'Attachement'
        ];
    }

    public function messages()
    {
        return [
            'message.required' => ':attribute tidak boleh kosong',
            'attachment.mimes' => 'Tipe :attribute harus :values.',
        ];
    }
}
