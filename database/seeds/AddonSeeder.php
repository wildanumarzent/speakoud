<?php

use App\Models\Instansi\InstansiInternal;
use App\Models\Instansi\InstansiMitra;
use App\Models\Users\Instruktur;
use App\Models\Users\Internal;
use App\Models\Users\Mitra;
use App\Models\Users\Peserta;
use App\Models\Users\User;
use App\Models\Users\UserInformation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AddonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        #--- instansi
        $instansiInternal = InstansiInternal::create([
            'creator_id' => 2,
            'kode_instansi' => '15017',
            'nip_pimpinan' => '012345',
            'nama_pimpinan' => 'Dr. Aton Yulianto, SSi. M. Eng.',
            'nama_instansi' => 'SPEAKOUD',
            'jabatan' => 'Kepala Pusbindiklat'
        ]);
        $instansiMitra = InstansiMitra::create([
            'creator_id' => 2,
            'kode_instansi' => '42007',
            'nama_pimpinan' => 'Muhammad Ihsan Firdaus',
            'nama_instansi' => 'CAA Telco',
            'jabatan' => 'CTO'
        ]);

        #-- user bppt
        $userInternal = User::create([
            'name' => 'Sakina Rahmania',
            'email' => 'sakina@gmail.com',
            'email_verified' => 1,
            'email_verified_at' => now(),
            'username' => 'sakina',
            'password' => Hash::make('admin123'),
            'active' => 1,
            'active_at' => now(),
            'photo' => [
                'filename' => null,
                'description' => null,
            ],
        ]);
        $userInternal->assignRole('internal');
        $informasiInternal = UserInformation::create([
            'user_id' => $userInternal->id,
        ]);
        $internal = Internal::create([
            'user_id' => $userInternal->id,
            'creator_id' => 2,
            'instansi_id' => $instansiInternal->id,
            'nip' => '001',
            'kedeputian' => 'KABPPT',
            'pangkat' => 0,
            'sk_cpns' => [
                'file' => null,
                'keterangan' => null,
            ],
            'sk_pengangkatan' => [
                'file' => null,
                'keterangan' => null,
            ],
            'sk_golongan' => [
                'file' => null,
                'keterangan' => null,
            ],
            'sk_jabatan' => [
                'file' => null,
                'keterangan' => null,
            ],
        ]);

        #-- user mitra
        $userMitra = User::create([
            'name' => 'Sholeh Effendy',
            'email' => 'sholeh@gmail.com',
            'email_verified' => 1,
            'email_verified_at' => now(),
            'username' => 'sholeh',
            'password' => Hash::make('admin123'),
            'active' => 1,
            'active_at' => now(),
            'photo' => [
                'filename' => null,
                'description' => null,
            ],
        ]);
        $userMitra->assignRole('mitra');
        $informasiMitra = UserInformation::create([
            'user_id' => $userMitra->id,
        ]);
        $mitra = Mitra::create([
            'user_id' => $userMitra->id,
            'creator_id' => 2,
            'instansi_id' => $instansiMitra->id,
            'nip' => '002',
            'kedeputian' => 'Project Division',
            'pangkat' => 0,
            'sk_cpns' => [
                'file' => null,
                'keterangan' => null,
            ],
            'sk_pengangkatan' => [
                'file' => null,
                'keterangan' => null,
            ],
            'sk_golongan' => [
                'file' => null,
                'keterangan' => null,
            ],
            'sk_jabatan' => [
                'file' => null,
                'keterangan' => null,
            ],
        ]);

        #--instruktur 1
        $userInstruktur1 = User::create([
            'name' => 'Budi Setiadi Sadikin',
            'email' => 'budi@gmail.com',
            'email_verified' => 1,
            'email_verified_at' => now(),
            'username' => 'budi.setiadi',
            'password' => Hash::make('admin123'),
            'active' => 1,
            'active_at' => now(),
            'photo' => [
                'filename' => null,
                'description' => null,
            ],
        ]);
        $userInstruktur1->assignRole('instruktur_internal');
        $informasiInstruktur1 = UserInformation::create([
            'user_id' => $userInstruktur1->id,
        ]);
        $instruktur1 = Instruktur::create([
            'user_id' => $userInstruktur1->id,
            'creator_id' => 2,
            'instansi_id' => $instansiInternal->id,
            'nip' => '003',
            'kedeputian' => null,
            'pangkat' => 'Fungsional',
            'sk_cpns' => [
                'file' => null,
                'keterangan' => null,
            ],
            'sk_pengangkatan' => [
                'file' => null,
                'keterangan' => null,
            ],
            'sk_golongan' => [
                'file' => null,
                'keterangan' => null,
            ],
            'sk_jabatan' => [
                'file' => null,
                'keterangan' => null,
            ],
        ]);

        #--instruktur 2
        $userInstruktur2 = User::create([
            'name' => 'Prafitri Dimarmayasari, M. Psi',
            'email' => 'prafitri@gmail.com',
            'email_verified' => 1,
            'email_verified_at' => now(),
            'username' => 'prafitri',
            'password' => Hash::make('admin123'),
            'active' => 1,
            'active_at' => now(),
            'photo' => [
                'filename' => null,
                'description' => null,
            ],
        ]);
        $userInstruktur2->assignRole('instruktur_internal');
        $informasiInstruktur2 = UserInformation::create([
            'user_id' => $userInstruktur2->id,
        ]);
        $instruktur1 = Instruktur::create([
            'user_id' => $userInstruktur2->id,
            'creator_id' => 2,
            'instansi_id' => $instansiInternal->id,
            'nip' => '004',
            'kedeputian' => null,
            'pangkat' => 'Fungsional',
            'sk_cpns' => [
                'file' => null,
                'keterangan' => null,
            ],
            'sk_pengangkatan' => [
                'file' => null,
                'keterangan' => null,
            ],
            'sk_golongan' => [
                'file' => null,
                'keterangan' => null,
            ],
            'sk_jabatan' => [
                'file' => null,
                'keterangan' => null,
            ],
        ]);

        #--peserta 1
        $userPeserta1 = User::create([
            'name' => 'Agus Dwiono',
            'email' => 'agus@gmail.com',
            'email_verified' => 1,
            'email_verified_at' => now(),
            'username' => 'agus.dwiono',
            'password' => Hash::make('admin123'),
            'active' => 1,
            'active_at' => now(),
            'photo' => [
                'filename' => null,
                'description' => null,
            ],
        ]);
        $userPeserta1->assignRole('peserta_internal');
        $informasiPeserta1 = UserInformation::create([
            'user_id' => $userPeserta1->id,
        ]);
        $peserta1 = Peserta::create([
            'user_id' => $userPeserta1->id,
            'creator_id' => 2,
            'instansi_id' => $instansiInternal->id,
            'nip' => '005',
            'kedeputian' => 'KABPPT',
            'pangkat' => 0,
            'sk_cpns' => [
                'file' => null,
                'keterangan' => null,
            ],
            'sk_pengangkatan' => [
                'file' => null,
                'keterangan' => null,
            ],
            'sk_golongan' => [
                'file' => null,
                'keterangan' => null,
            ],
            'sk_jabatan' => [
                'file' => null,
                'keterangan' => null,
            ],
            'surat_ijin_atasan' => [
                'file' => null,
                'keterangan' => null,
            ],
        ]);

        #--peserta 2
        $userPeserta2 = User::create([
            'name' => 'Junita, S.IP., M.E',
            'email' => 'junita@gmail.com',
            'email_verified' => 1,
            'email_verified_at' => now(),
            'username' => 'junita',
            'password' => Hash::make('admin123'),
            'active' => 1,
            'active_at' => now(),
            'photo' => [
                'filename' => null,
                'description' => null,
            ],
        ]);
        $userPeserta2->assignRole('peserta_internal');
        $informasiPeserta2 = UserInformation::create([
            'user_id' => $userPeserta2->id,
        ]);
        $peserta2 = Peserta::create([
            'user_id' => $userPeserta2->id,
            'creator_id' => 2,
            'instansi_id' => $instansiInternal->id,
            'nip' => '006',
            'kedeputian' => 'KABPPT',
            'pangkat' => 0,
            'sk_cpns' => [
                'file' => null,
                'keterangan' => null,
            ],
            'sk_pengangkatan' => [
                'file' => null,
                'keterangan' => null,
            ],
            'sk_golongan' => [
                'file' => null,
                'keterangan' => null,
            ],
            'sk_jabatan' => [
                'file' => null,
                'keterangan' => null,
            ],
            'surat_ijin_atasan' => [
                'file' => null,
                'keterangan' => null,
            ],
        ]);
    }
}
