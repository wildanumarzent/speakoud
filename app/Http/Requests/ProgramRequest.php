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
                        'price' => 'required | integer',

                    ];
                } else {
                    return [
                        'judul' => 'required',
                        'price' => 'required | integer',
                    ];
                }

            } else {
                return [
                    'judul' => 'required',
                    'price' => 'required | integer',
                ];
            }

        } else {
            return [
                'judul' => 'required',
                'price' => 'required | integer',
            ];
        }

    }

    public function attributes()
    {
        return [
            'judul' => 'Judul',
            'price' => 'required | integer',
        ];
    }

    public function messages()
    {
        return [
            'judul.required' => ':attribute tidak boleh kosong',
            'price.required' => ': harga tidak boleh kosong',
            'price.integer' => ': harga harus angka'
        ];
    }
}
