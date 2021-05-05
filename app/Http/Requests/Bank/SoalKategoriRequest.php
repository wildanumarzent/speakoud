<?php

namespace App\Http\Requests\Bank;

use Illuminate\Foundation\Http\FormRequest;

class SoalKategoriRequest extends FormRequest
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
        ];
    }

    public function attributes()
    {
        return [
            'judul' => 'Judul',
        ];
    }

    public function messages()
    {
        return [
            'judul.required' => ':attribute tidak boleh kosong',
        ];
    }
}
