<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TemplateBahanRequest extends FormRequest
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
        if ($this->completion_type == 3) {
            $defaultBahan = [
                'judul' => 'required',
                'completion_duration' => 'required',
            ];
        } elseif ($this->completion_type == 3 && $this->restrict_access == '0') {
            $defaultBahan = [
                'judul' => 'required',
                'completion_duration' => 'required',
                'requirement' => 'required',
            ];
        } elseif ($this->restrict_access == '0') {
            $defaultBahan = [
                'judul' => 'required',
                'requirement' => 'required',
            ];
        } else {
            $defaultBahan = [
                'judul' => 'required',
            ];
        }

        if ($this->type == 'forum') {
            $forum = [
                'tipe' => 'required',
            ];

            return array_merge($defaultBahan, $forum);
        }

        if ($this->type == 'dokumen') {
            $dokumen = [
                'file_path' => 'required',
            ];

            return array_merge($defaultBahan, $dokumen);
        }

        if ($this->type == 'conference') {
            return $defaultBahan;
        }

        if ($this->type == 'quiz') {

            if ($this->kategori <= 3 && $this->is_mandatory == 1) {
                if ((bool)$this->soal_acak == 1) {
                    $quiz = [
                        'kategori' => 'required',
                        'durasi' => 'required',
                        'jml_soal_acak' => 'required',
                    ];
                } else {
                    $quiz = [
                        'kategori' => 'required',
                        'durasi' => 'required',
                    ];
                }
                
            } else {
                if ((bool)$this->soal_acak == 1) {
                    $quiz = [
                        'durasi' => 'required',
                        'jml_soal_acak' => 'required',
                    ];
                } else {
                    $quiz = [
                        'durasi' => 'required',
                    ];
                }
            }

            return array_merge($defaultBahan, $quiz);
        }

        if ($this->type == 'scorm') {
            if ($this->method() == 'POST') {
                $scorm = [
                    'package' => 'required|mimes:'.config('addon.mimes.package_scorm.m'),
                    'repeatable' => 'nullable',
                ];

                return array_merge($defaultBahan, $scorm);
            } else {
                $scorm = [
                    'package' => 'nullable|mimes:'.config('addon.mimes.package_scorm.m'),
                    'repeatable' => 'nullable',
                ];

                return array_merge($defaultBahan, $scorm);
            }
        }

        if ($this->type == 'audio') {
            $audio = [
                'file_path' => 'required',
            ];

            return array_merge($defaultBahan, $audio);
        }

        if ($this->type == 'video') {
            // $video = [
            //     'file_path' => 'required',
            // ];

            // return array_merge($defaultBahan, $video);

            return $defaultBahan;
        }

        if ($this->type == 'tugas') {
            if ($this->method() == 'PUT') {
                return $defaultBahan;
            } else {
                $tugas = [
                    'files' => 'required|array',
                    'files.*' => 'required|max:50000|distinct|mimes:'.config('addon.mimes.tugas.m'),
                ];

                return array_merge($defaultBahan, $tugas);
            }
        }
    }

    public function attributes()
    {
        return [
            'judul' => 'Judul',
            'completion_duration' => 'Durasi Completion',
            'requirement' => 'Materi',
            'tipe' => 'Tipe',
            'file_path' => 'File Path',
            'package' => 'Package',
            'files' => 'Files',
            'end_time' => 'Jam Selesai',
            'kategori' => 'Kategori',
            'durasi' => 'Durasi',
            'jml_soal_acak' => 'Jumlah Soal Acak',
        ];
    }

    public function messages()
    {
        return [
            'judul.required' => ':attribute tidak boleh kosong',
            'completion_duration.required' => ':attribute tidak boleh kosong',
            'requirement.required' => ':attribute tidak boleh kosong',
            'tipe.required' => ':attribute tidak boleh kosong',
            'file_path.required' => ':attribute tidak boleh kosong',
            'package.required' => ':attribute tidak boleh kosong',
            'package.mimes' => 'Tipe :attribute harus :values.',
            'files.required' => ':attribute tidak boleh kosong',
            'files.mimes' => 'Tipe :attribute harus :values.',
            'kategori.required' => ':attribute tidak boleh kosong',
            'durasi.required' => ':attribute tidak boleh kosong',
            'jml_soal_acak.required' => ':attribute tidak boleh kosong',
        ];
    }
}
