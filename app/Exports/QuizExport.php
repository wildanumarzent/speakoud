<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class QuizExport implements FromView,ShouldAutoSize
{
    protected $quiz, $peserta;

    public function __construct($quiz, $peserta)
    {
        $this->quiz = $quiz;
        $this->peserta = $peserta;
    }

    public function view(): View
    {
        $quiz = $this->quiz;
        $peserta = $this->peserta;
        return view('table.quizUser', [
            'quiz' => $quiz,
            'peserta' => $peserta
        ]);
    }
}
