<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EvaluasiPengajarExport implements
    WithMultipleSheets
{
    use Exportable;

    protected $mata, $bahan, $detail, $pg, $essay;

    public function __construct($mata, $bahan, $detail, $pg, $essay)
    {
        $this->mata = $mata;
        $this->bahan = $bahan;
        $this->detail = $detail;
        $this->pg = $pg;
        $this->essay = $essay;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        if (count($this->essay) > 0) {
            $evaluasi = ['PG', 'ESSAY'];
        } else {
            $evaluasi = ['PG'];
        }


        foreach ($evaluasi as $key => $value) {
            $sheets[] = new EvaluasiPengajarSheet($this->mata, $this->bahan, $this->detail, $this->pg, $this->essay, $value);
        }

        return $sheets;
    }
}
