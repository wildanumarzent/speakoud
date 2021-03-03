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
    WithHeadingRow,
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
        if ($row['tipe'] == 'multiple_choice') {
            $tipe = 0;
        } elseif ($row['tipe'] == 'exact') {
            $tipe = 1;
        } elseif ($row['tipe'] == 'true_false') {
            $tipe = 3;
        } else {
            $tipe = 2;
        }

        if ($row['tipe'] == 'multiple_choice' && $row['pilihan'] != null) {
            $str = $row['pilihan'];
            $collect = trim($str, ";");
            $pilihan = explode(";", $collect);
            $jawaban = "0";
        }

        if ($row['tipe'] == 'exact' && $row['pilihan'] != null) {
            $str = $row['pilihan'];
            $collect = trim($str, ";");
            $jawaban = explode(";", $collect);
        }

        if ($row['tipe'] == 'exact' && $row['pilihan'] != null) {
            $str = $row['pilihan'];
            $jawaban = (strtoupper($str) == 'T') ? 1 : 0;
        }

        $soal = new Soal;
        $soal->mata_id = request()->segment(2);
        $soal->kategori_id = request()->segment(5);
        $soal->creator_id = auth()->user()->id;
        $soal->pertanyaan = $row['pertanyaan'];
        $soal->tipe_jawaban = $tipe;
        $soal->pilihan = $pilihan ?? null;
        $soal->jawaban = $jawaban ?? null;
        $soal->save();

        return $soal;
    }

    public function rules(): array
    {
        return [
            '*.tipe' => 'required',
            '*.pertanyaan' => 'required',
        ];
    }

    public function customValidationAttributes()
    {
        return [
            'tipe' => 'tipe',
            'pertanyaan' => 'pertanyaan',
            'pilihan' => 'pilihan',
            'jawaban' => 'jawaban',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'tipe.required' => ':attribute tidak boleh kosong',
            'pertanyaan.required' => ':attribute tidak boleh kosong',
            'pilihan.required' => ':attribute tidak boleh kosong',
            'jawaban.required' => ':attribute tidak boleh kosong',
        ];
    }
}
