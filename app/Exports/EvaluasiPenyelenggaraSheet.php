<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class EvaluasiPenyelenggaraSheet implements
    FromView,
    WithEvents,
    WithTitle
{
    use Exportable;

    protected $mata, $detail, $pg, $essay, $value;

    public function __construct($mata, $detail, $pg, $essay, $value)
    {
        $this->mata = $mata;
        $this->detail = $detail;
        $this->pg = $pg;
        $this->essay = $essay;
        $this->value = $value;
    }

    public function view(): View
    {
        $mata = $this->mata;
        $detail = $this->detail;
        $pg = $this->pg;
        $essay = $this->essay;

        if ($this->value === 'PG') {
            return view('frontend.course.evaluasi.export.penyelenggara-sheet-1', [
                'mata' => $mata,
                'detail' => $detail,
                'pg' => $pg
            ]);
        } else {

            return view('frontend.course.evaluasi.export.penyelenggara-sheet-2', [
                'mata' => $mata,
                'detail' => $detail,
                'essay' => $essay
            ]);
        }
        //  View jeung essay;
        // return view('....................');
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                if ($this->value === 'PG') {
                    $styleHeader = [
                        'font' => [
                            'bold' => true,
                            'size' => 12
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],
                        ],
                    ];
                    $styleContent = [
                        'borders' => [
                            'font' => [
                                'size' => 12
                            ],
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],
                        ],
                    ];
                    $styleTotalSistem = [
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                        ],
                    ];
                    $highestColumn = $event->sheet->getHighestColumn();
                    $highestRow = $event->sheet->getHighestRow();

                    // $event->sheet->mergeCells('A' . $highestRow . ':' . 'B' . $highestRow);
                    // $event->sheet->mergeCells('A' . '1' . ':' . 'K' . '1');

                    $event->sheet->getStyle('A2:' . $highestColumn . '2')->applyFromArray($styleHeader);
                    $event->sheet->getStyle('A3:' . $highestColumn . $highestRow)->applyFromArray($styleContent);
                    $event->sheet->getStyle('A' . $highestRow . ':' . 'B' . $highestRow)->applyFromArray($styleTotalSistem);
                } else {
                    //  Kumaha jeung essay
                    $styleHeader = [
                        'font' => [
                            'bold' => true,
                            'size' => 12
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],
                        ],
                    ];
                    $styleContent = [
                        'borders' => [
                            'font' => [
                                'size' => 12
                            ],
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],
                        ],
                    ];
                    $styleTotalSistem = [
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                        ],
                    ];
                    $highestColumn = $event->sheet->getHighestColumn();
                    $highestRow = $event->sheet->getHighestRow();

                    // $event->sheet->mergeCells('A' . $highestRow . ':' . 'B' . $highestRow);
                    // $event->sheet->mergeCells('A' . '1' . ':' . 'C' . '1');

                    $event->sheet->getStyle('A2:' . $highestColumn . '2')->applyFromArray($styleHeader);
                    $event->sheet->getStyle('A3:' . $highestColumn . $highestRow)->applyFromArray($styleContent);
                    $event->sheet->getStyle('A' . $highestRow . ':' . 'B' . $highestRow)->applyFromArray($styleTotalSistem);
                }
            },
        ];
    }

    public function title(): string
    {
        if ($this->value === 'PG') {
            return 'PG';
        } else {
            return 'ESSAY';
        }
    }
}
