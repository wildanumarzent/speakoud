<?php

namespace App\Imports;

use App\Models\Soal\Soal;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BankSoalImport implements 
    ToModel,
    WithStartRow,
    // WithHeadingRow,
    WithValidation,
    SkipsOnError,
    SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $indexPilih = count($row);

        $soal = new Soal;
        $soal->mata_id = request()->segment(2);
        $soal->kategori_id = request()->segment(5);
        $soal->creator_id = auth()->user()->id;
        $soal->pertanyaan = $row[1];
        
        if ($row[0] == 'multiple_choice') {

            $pilihan = [];
            for ($i=2; $i < $indexPilih; $i++) {
                if (!empty($row[$i])) {
                    $pilihan[($i-2)] = $row[$i];
                }
            }

            $soal->tipe_jawaban = 0;
            $soal->pilihan = $pilihan;
            $soal->jawaban = "0";
        }

        if ($row[0] == 'exact') {
            
            $jawaban = [];
            for ($i=2; $i < $indexPilih; $i++) {
                if (!empty($row[$i])) {
                    $jawaban[($i-2)] = $row[$i];
                }
            }

            $soal->tipe_jawaban = 1;
            $soal->pilihan = null;
            $soal->jawaban = $jawaban;

        }

        if ($row[0] == 'essay') {

            $soal->tipe_jawaban = 2;
            $soal->pilihan = null;
            $soal->jawaban = null;

        }

        if ($row[0] == 'true_false') {
            $soal->tipe_jawaban = 3;
            $soal->pilihan = null;
            $soal->jawaban = (strtoupper($row[2]) == 'T') ? 1 : 0;
        }

        $soal->save();

        return $soal;
    }

    public function rules(): array
    {
        return [
            '*.0' => 'required',
            '*.1' => 'required',
        ];
    }

    public function customValidationAttributes()
    {
        return [
            '0' => 'tipe',
            '1' => 'pertanyaan',
            // 'pilihan' => 'pilihan',
            // 'jawaban' => 'jawaban',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'tipe.required' => ':attribute tidak boleh kosong',
            'pertanyaan.required' => ':attribute tidak boleh kosong',
            // 'pilihan.required' => ':attribute tidak boleh kosong',
            // 'jawaban.required' => ':attribute tidak boleh kosong',
        ];
    }
}
