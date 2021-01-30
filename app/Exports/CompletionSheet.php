<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class CompletionSheet implements FromView,WithTitle,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $mata;
    protected $peserta;
    protected $track;

    public function __construct($mata,$peserta,$track)
    {
        $this->mata = $mata;
        $this->peserta = $peserta;
        $this->track = $track;

    }



    public function view(): View
    {
        $data['mata'] = $this->mata;
        $data['peserta'] = $this->peserta;
        $data['track'] = $this->track;
        return view('table.activity',compact('data'));
    }

    public function title(): string
    {
        return 'Activity Completion';
    }


}
