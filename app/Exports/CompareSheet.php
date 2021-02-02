<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class CompareSheet implements FromView,WithTitle,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $mata;
    protected $peserta;
    protected $pre,$post;
    public function __construct($mata,$peserta,$pre,$post)
    {
        $this->mata = $mata;
        $this->peserta = $peserta;
        $this->pre = $pre;
        $this->post = $post;
    }
    public function title(): string
    {
        return 'Compare Test';
    }

    public function view(): View
    {
        $data['mata'] = $this->mata;
        $data['peserta'] = $this->peserta;
        $data['pre'] = $this->pre;
        $data['post'] = $this->post;
        return view('table.compare',compact('data'));
    }
}
