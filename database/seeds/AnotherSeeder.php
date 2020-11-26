<?php

use App\Models\Instansi\InstansiInternal;
use App\Models\Instansi\InstansiMitra;
use Illuminate\Database\Seeder;

class AnotherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        #--- instansi
        InstansiInternal::create([
            'creator_id' => 2,
            'nip_pimpinan' => '012345',
            'nama_pimpinan' => 'Dr. Ir. Hammam Riza, M.Sc.',
            'nama_instansi' => 'Badan Pengkajian & Penelitian Teknologi',
            'jabatan' => 'Kepala BPPT'
        ]);

        InstansiMitra::create([
            'creator_id' => 2,
            'nama_pimpinan' => 'Muhammad Ihsan Firdaus',
            'nama_instansi' => 'CAA Telco',
            'jabatan' => 'CTO'
        ]);

        #-- user bppt

    }
}
