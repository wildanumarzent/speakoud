<?php

namespace App\Http\Requests\Bank;

use Illuminate\Foundation\Http\FormRequest;

class SoalRequest extends FormRequest
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
        if ($this->tipe_jawaban == 0) {
            return [
                'pertanyaan' => 'required|string',
                'pilihan.*' => 'required',
            ];
        } elseif ($this->tipe_jawaban == 1) {
            return [
                'pertanyaan' => 'required|string',
                'jawaban.*' => 'required',
            ];
        }  elseif ($this->tipe_jawaban == 3) {
            return [
                'pertanyaan' => 'required|string',
                'jawaban' => 'required',
            ];
        } else {
            return [
                'pertanyaan' => 'required|string',
            ];
        }
    }

    public function attributes()
    {
        return [
            'pertanyaan' => 'Pertanyaan',
            'pilihan' => 'Pilihan',
            'jawaban' => 'Jawaban',
        ];
    }

    public function messages()
    {
        return [
            'pertanyaan.required' => ':attribute tidak boleh kosong',
            'pilihan.*.required' => 'Pilihan tidak boleh kosong',
            'jawaban.*.required' => 'Jawaban tidak boleh kosong',
        ];
    }
}
