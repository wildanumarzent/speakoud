<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PesertaExport implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $peserta;

    public function __construct($peserta)
    {
        $this->peserta = $peserta;

    }



    public function view(): View
    {
        $data['peserta'] = $this->peserta;
        return view('table.peserta',compact('data'));
    }

}
