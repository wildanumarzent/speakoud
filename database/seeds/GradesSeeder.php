<?php

use App\Models\Grades\GradesKategori;
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
                'kategori_id' => 1,
                'creator_id' => 2,
                'minimum' => 100,
                'maksimum' => 93,
                'keterangan' => 'A',
            ],
            1 => [
                'kategori_id' => 1,
                'creator_id' => 2,
                'minimum' => '92.99',
                'maksimum' => 90,
                'keterangan' => 'A-',
            ],
            2 => [
                'kategori_id' => 1,
                'creator_id' => 2,
                'minimum' => '89.99',
                'maksimum' => 87,
                'keterangan' => 'B+',
            ],
            3 => [
                'kategori_id' => 1,
                'creator_id' => 2,
                'minimum' => '86.99',
                'maksimum' => 83,
                'keterangan' => 'B',
            ],
            4 => [
                'kategori_id' => 1,
                'creator_id' => 2,
                'minimum' => '82.99',
                'maksimum' => 80,
                'keterangan' => 'B-',
            ],
            5 => [
                'kategori_id' => 1,
                'creator_id' => 2,
                'minimum' => '79.99',
                'maksimum' => 77,
                'keterangan' => 'C+',
            ],
            6 => [
                'kategori_id' => 1,
                'creator_id' => 2,
                'minimum' => '76.99',
                'maksimum' => 73,
                'keterangan' => 'C',
            ],
            7 => [
                'kategori_id' => 1,
                'creator_id' => 2,
                'minimum' => '72.99',
                'maksimum' => 70,
                'keterangan' => 'C-',
            ],
            8 => [
                'kategori_id' => 1,
                'creator_id' => 2,
                'minimum' => '69.99',
                'maksimum' => 67,
                'keterangan' => 'D+',
            ],
            9 => [
                'kategori_id' => 1,
                'creator_id' => 2,
                'minimum' => '66.99',
                'maksimum' => 60,
                'keterangan' => 'D',
            ],
            10 => [
                'kategori_id' => 1,
                'creator_id' => 2,
                'minimum' => '59.99',
                'maksimum' => 0,
                'keterangan' => 'F',
            ],
        ];
    }
}
