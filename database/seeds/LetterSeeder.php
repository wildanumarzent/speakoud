<?php

use App\Models\Grades\PersenNilai;
use Illuminate\Database\Seeder;

class LetterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $letter = [
            0 => [
                'nilai_maksimum' => '100.00',
                'nilai_minimum' => '93.00',
                'angka' => 'A',
            ],
            1 => [
                'nilai_maksimum' => '92.99',
                'nilai_minimum' => '90.00',
                'angka' => 'A-',
            ],
            2 => [
                'nilai_maksimum' => '89.99',
                'nilai_minimum' => '87.00',
                'angka' => 'B+',
            ],
            3 => [
                'nilai_maksimum' => '86.99',
                'nilai_minimum' => '83.00',
                'angka' => 'B',
            ],
            4 => [
                'nilai_maksimum' => '82.99',
                'nilai_minimum' => '80.00',
                'angka' => 'B-',
            ],
            5 => [
                'nilai_maksimum' => '79.99',
                'nilai_minimum' => '77.00',
                'angka' => 'C+',
            ],
            6 => [
                'nilai_maksimum' => '76.99',
                'nilai_minimum' => '73.00',
                'angka' => 'C',
            ],
            7 => [
                'nilai_maksimum' => '72.99',
                'nilai_minimum' => '70.00',
                'angka' => 'C-',
            ],
            8 => [
                'nilai_maksimum' => '69.99',
                'nilai_minimum' => '67.00',
                'angka' => 'D+',
            ],
            9 => [
                'nilai_maksimum' => '66.99',
                'nilai_minimum' => '60.00',
                'angka' => 'D',
            ],
            10 => [
                'nilai_maksimum' => '59.99',
                'nilai_minimum' => '0.00',
                'angka' => 'E',
            ],
        ];

        foreach ($letter as $value) {
            PersenNilai::create([
                'creator_id' => 2,
                'nilai_minimum' => $value['nilai_minimum'],
                'nilai_maksimum' => $value['nilai_maksimum'],
                'angka' => $value['angka']
            ]);
        }
    }
}
