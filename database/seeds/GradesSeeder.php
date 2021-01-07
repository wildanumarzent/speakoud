<?php

use App\Models\Grades\GradesKategori;
use App\Models\Grades\GradesNilai;
use Illuminate\Database\Seeder;

class GradesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GradesKategori::create([
            'creator_id' => 2,
            'nama' => 'Letters',
        ]);

        $nilai = [
            0 => [
                'maksimum' => 100,
                'minimum' => 93,
                'keterangan' => 'A',
            ],
            1 => [
                'maksimum' => '92.99',
                'minimum' => 90,
                'keterangan' => 'A-',
            ],
            2 => [
                'maksimum' => '89.99',
                'minimum' => 87,
                'keterangan' => 'B+',
            ],
            3 => [
                'maksimum' => '86.99',
                'minimum' => 83,
                'keterangan' => 'B',
            ],
            4 => [
                'maksimum' => '82.99',
                'minimum' => 80,
                'keterangan' => 'B-',
            ],
            5 => [
                'maksimum' => '79.99',
                'minimum' => 77,
                'keterangan' => 'C+',
            ],
            6 => [
                'maksimum' => '76.99',
                'minimum' => 73,
                'keterangan' => 'C',
            ],
            7 => [
                'maksimum' => '72.99',
                'minimum' => 70,
                'keterangan' => 'C-',
            ],
            8 => [
                'maksimum' => '69.99',
                'minimum' => 67,
                'keterangan' => 'D+',
            ],
            9 => [
                'maksimum' => '66.99',
                'minimum' => 60,
                'keterangan' => 'D',
            ],
            10 => [
                'maksimum' => '59.99',
                'minimum' => 0,
                'keterangan' => 'F',
            ],
        ];

        foreach ($nilai as $key => $value) {
            GradesNilai::create([
                'kategori_id' => 1,
                'creator_id' => 2,
                'maksimum' => $value['maksimum'],
                'minimum' => $value['minimum'],
                'keterangan' => $value['keterangan'],
            ]);
        }
    }
}
