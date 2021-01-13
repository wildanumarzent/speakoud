<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EvaluasiPenyelenggaraExport implements
    WithMultipleSheets
{
    use Exportable;

    protected $mata, $detail, $pg, $essay;

    public function __construct($mata, $detail, $pg, $essay)
    {
        $this->mata = $mata;
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
            $sheets[] = new EvaluasiPenyelenggaraSheet($this->mata, $this->detail, $this->pg, $this->essay, $value);
        }

        return $sheets;
    }
}
