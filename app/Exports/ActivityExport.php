<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\CompareSheet;
use App\Exports\CompletionSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ActivityExport implements WithMultipleSheets,ShouldAutoSize
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $mata;
    protected $peserta;
    protected $track;
    protected $pre;
    protected $post;

    public function __construct($mata,$peserta,$track,$pre,$post)
    {
        $this->mata = $mata;
        $this->peserta = $peserta;
        $this->track = $track;
        $this->pre = $pre;
        $this->post = $post;
    }
    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new PembobotanSheet($this->mata,$this->peserta);
        $sheets[] = new CompletionSheet($this->mata,$this->peserta,$this->track);
        $sheets[] = new CompareSheet($this->mata,$this->peserta,$this->pre,$this->post);
        return $sheets;
    }
}
