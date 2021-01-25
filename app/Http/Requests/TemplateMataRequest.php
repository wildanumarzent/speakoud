<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TemplateMataRequest extends FormRequest
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
            'content' => 'required',
            'join_vidconf' => 'required',
            'activity_completion' => 'required',
            'forum_diskusi' => 'required',
            'webinar' => 'required',
            'quiz' => 'required',
            'post_test' => 'required',
        ];

    }

    public function attributes()
    {
        return [
            'judul' => 'Judul',
            'content' => 'Deskripsi',
            'join_vidconf' => 'Video Conference',
            'activity_completion' => 'Activity Completion',
            'forum_diskusi' => 'Forum Diskusi',
            'webinar' => 'Webinar',
            'progress_test' => 'Progress Test',
            'quiz' => 'Quiz',
            'post_test' => 'Post Test',
        ];
    }

    public function messages()
    {
        return [
            'judul.required' => ':attribute tidak boleh kosong',
            'content.required' => ':attribute tidak boleh kosong',
            'join_vidconf.required' => ':attribute tidak boleh kosong',
            'activity_completion.required' => ':attribute tidak boleh kosong',
            'forum_diskusi.required' => ':attribute tidak boleh kosong',
            'webinar.required' => ':attribute tidak boleh kosong',
            'progress_test.required' => ':attribute tidak boleh kosong',
            'quiz.required' => ':attribute tidak boleh kosong',
            'post_test.required' => ':attribute tidak boleh kosong',
        ];
    }
}