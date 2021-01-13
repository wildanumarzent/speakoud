<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BahanRequest extends FormRequest
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
        } elseif ($this->completion_type == 3 && $this->restrict_access == 1) {
            $defaultBahan = [
                'judul' => 'required',
                'completion_duration' => 'required',
                'publish_start' => 'required',
                'publish_end' => 'required',
            ];
        } elseif ($this->restrict_access == '0') {
            $defaultBahan = [
                'judul' => 'required',
                'requirement' => 'required',
            ];
        } elseif ($this->restrict_access == 1) {
            $defaultBahan = [
                'judul' => 'required',
                'publish_start' => 'required',
                'publish_end' => 'required',
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
            if ($this->tipe == 1) {
                $conference = [
                    'meeting_link' => 'required',
                    'tanggal' => 'required',
                    'start_time' => 'required',
                    'end_time' => 'required',
                ];

                return array_merge($defaultBahan, $conference);
            } else {
                $conference = [
                    'tanggal' => 'required',
                    'start_time' => 'required',
                    'end_time' => 'required',
                ];

                return array_merge($defaultBahan, $conference);
            }
        }

        if ($this->type == 'quiz') {

            if ($this->kategori <= 3 && $this->is_mandatory == 1) {
                $quiz = [
                    'kategori' => 'required',
                    'durasi' => 'required',
                ];
            } else {
                $quiz = [
                    'durasi' => 'required',
                ];
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
            $video = [
                'file_path' => 'required',
            ];

            return array_merge($defaultBahan, $video);
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

        if ($this->type == 'evaluasi-pengajar') {
            $evaluasi = [
                'mata_instruktur_id' => 'required',
            ];

            return array_merge($defaultBahan, $evaluasi);
        }
    }

    public function attributes()
    {
        return [
            'judul' => 'Judul',
            'completion_duration' => 'Durasi Completion',
            'requirement' => 'Materi',
            'publish_start' => 'Tanggal Mulai',
            'publish_end' => 'Tanggal Selesai',
            'tipe' => 'Tipe',
            'file_path' => 'File Path',
            'meeting_link' => 'Meeting Link',
            'package' => 'Package',
            'files' => 'Files',
            'mata_instruktur_id' => 'Instruktur',
            'tanggal' => 'Tanggal',
            'start_time' => 'Jam Mulai',
            'end_time' => 'Jam Selesai',
            'kategori' => 'Kategori',
            'durasi' => 'Durasi',
        ];
    }

    public function messages()
    {
        return [
            'judul.required' => ':attribute tidak boleh kosong',
            'completion_duration.required' => ':attribute tidak boleh kosong',
            'requirement.required' => ':attribute tidak boleh kosong',
            'publish_start.required' => ':attribute tidak boleh kosong',
            'publish_end.required' => ':attribute tidak boleh kosong',
            'tipe.required' => ':attribute tidak boleh kosong',
            'file_path.required' => ':attribute tidak boleh kosong',
            'meeting_link.required' => ':attribute tidak boleh kosong',
            'package.required' => ':attribute tidak boleh kosong',
            'package.mimes' => 'Tipe :attribute harus :values.',
            'files.required' => ':attribute tidak boleh kosong',
            'files.mimes' => 'Tipe :attribute harus :values.',
            'mata_instruktur_id.required' => ':attribute tidak boleh kosong',
            'tanggal.required' => ':attribute tidak boleh kosong',
            'start_time.required' => ':attribute tidak boleh kosong',
            'end_time.required' => ':attribute tidak boleh kosong',
            'kategori.required' => ':attribute tidak boleh kosong',
            'durasi.required' => ':attribute tidak boleh kosong',
        ];
    }
}
