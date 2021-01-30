<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Services\Users\PesertaService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PembobotanSheet implements FromView,WithTitle,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $id;

    public function title(): string
    {
        return 'Pembobotan Nilai';
    }

    protected $mata;
    protected $peserta;

    public function __construct($mata,$peserta)
    {
        $this->mata = $mata;
        $this->peserta = $peserta;

    }



    public function view(): View
    {
        $data['mata'] = $this->mata;
        $data['peserta'] = $this->peserta;
        return view('table.bobot',compact('data'));
    }

}
