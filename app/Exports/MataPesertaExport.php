<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MataPesertaExport implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $peserta,$mata;

    public function __construct($peserta,$mata)
    {
        $this->peserta = $peserta;
        $this->mata = $mata;

    }



    public function view(): View
    {
        $data['peserta'] = $this->peserta;
        $data['mata'] = $this->mata;
        return view('table.peserta',compact('data'));
    }

}
