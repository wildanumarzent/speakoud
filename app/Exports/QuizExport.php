<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class QuizExport implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $peserta;
    protected $quizItem;
    protected $totalBenar;
    public function __construct($peserta,$quizItem,$totalBenar)
    {
        $this->peserta = $peserta;
        $this->quizItem = $quizItem;
        $this->totalBenar = $totalBenar;


    }

    public function view(): View
    {
        $data['peserta'] = $this->peserta;
        $data['quizItem'] = $this->quizItem;
        $data['totalBenar'] = $this->totalBenar;
        return view('table.quizUser',compact('data'));
    }
}
