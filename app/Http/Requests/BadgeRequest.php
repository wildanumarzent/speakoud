<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BadgeRequest extends FormRequest
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
            'deskripsi' => 'required',
            'nama' => 'required',
            'icon' => 'required|mimes:'.config('addon.mimes.cover.m'),
            'nilai_minimal' => 'required|numeric|min:1|max:100',
            'mata_id' => 'required',
            'tipe' => 'required',
            'tipe_utama' => 'nullable',
            'tipe_id' => 'required_unless:tipe,=,program',
        ];
    }else{
        return [
            'deskripsi' => 'required',
            'nama' => 'required',
            'icon' => 'nullable|mimes:'.config('addon.mimes.cover.m'),
            'nilai_minimal' => 'required|numeric|min:1|max:100',
            'mata_id' => 'required',
            'old_icon' => 'nullable',
            'tipe' => 'required',
            'tipe_utama' => 'nullable',
            'tipe_id' => 'required_unless:tipe,!=,program',
        ];
    }
    }
}
