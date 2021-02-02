<?php

use App\Models\Jabatan;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jabatan = [
            0 => [
                'nama' => 'Analis Anggaran',
            ],
            1 => [
                'nama' => 'Analis Kebijakan'
            ],
            2 => [
                'nama' => 'Analis Kepegawaian'
            ],
            3 => [
                'nama' => 'Arsiparis'
            ],
            4 => [
                'nama' => 'Auditor'
            ],
            5 => [
                'nama' => 'Dokter'
            ],
            6 => [
                'nama' => 'Dokter Gigi'
            ],
            7 => [
                'nama' => 'Peneliti'
            ],
            8 => [
                'nama' => 'Pengelola Pengadaan Barang dan Jasa'
            ],
            9 => [
                'nama' => 'Pengendali Dampak Lingkungan'
            ],
            10 => [
                'nama' => 'Perancang Perundang-Undangan'
            ],
            11 => [
                'nama' => 'Perawat'
            ],
            12 => [
                'nama' => 'Perawat Gigi'
            ],
            13 => [
                'nama' => 'Perekayasa'
            ],
            14 => [
                'nama' => 'Perencana'
            ],
            15 => [
                'nama' => 'Pranata Humas'
            ],
            16 => [
                'nama' => 'Pranata Komputer'
            ],
            17 => [
                'nama' => 'Pustakawan'
            ],
            18 => [
                'nama' => 'Teknisi Litkayasa'
            ],
            19 => [
                'nama' => 'Widyaiswara'
            ],
        ];

        foreach ($jabatan as $key) {
            Jabatan::create([
                'nama' => $key['nama'],
                'keterangan' => null,
            ]);
        }
    }
}
