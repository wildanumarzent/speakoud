<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramRequest extends FormRequest
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
            if (auth()->user()->hasRole('developer|administrator')) {
                if ($this->tipe == 1) {
                    return [
                        'judul' => 'required',
                        'tipe' => 'required',
                        'mitra_id' => 'required'
                    ];
                } else {
                    return [
                        'judul' => 'required',
                        'tipe' => 'required'
                    ];
                }

            } else {
                return [
                    'judul' => 'required',
                ];
            }

        } else {
            return [
                'judul' => 'required',
            ];
        }

    }

    public function attributes()
    {
        return [
            'judul' => 'Judul',
            'tipe' => 'Tipe',
            'mitra_id' => 'Mitra'
        ];
    }

    public function messages()
    {
        return [
            'judul.required' => ':attribute tidak boleh kosong',
            'tipe.required' => ':attribute tidak boleh kosong',
            'mitra_id.required' => ':attribute tidak boleh kosong',
        ];
    }
}
