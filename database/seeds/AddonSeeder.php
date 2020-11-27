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
            'nip_pimpinan' => '012345',
            'nama_pimpinan' => 'Dr. Ir. Hammam Riza, M.Sc.',
            'nama_instansi' => 'Badan Pengkajian & Penelitian Teknologi',
            'jabatan' => 'Kepala BPPT'
        ]);
        $instansiMitra = InstansiMitra::create([
            'creator_id' => 2,
            'nama_pimpinan' => 'Muhammad Ihsan Firdaus',
            'nama_instansi' => 'CAA Telco',
            'jabatan' => 'CTO'
        ]);

        #-- user bppt
        $userInternal = User::create([
            'name' => 'Internal',
            'email' => 'internal@gmai.com',
            'email_verified' => 1,
            'email_verified_at' => now(),
            'username' => 'internal',
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
            'general' => [
                'city' => null,
                'description' => null,
            ],
            'additional_name' => [
                'first_name' => null,
                'sur_name' => null,
                'middle_name' => null,
                'alternate_name' => null,
            ],
            'optional' => [
                'web_page' => null,
                'icq_number' => null,
                'skype_id' => null,
                'aim_id' => null,
                'yahoo_id' => null,
                'msn_id' => null,
                'id_number' => null,
                'institution' => null,
                'departement' => null,
                'phone' => null,
                'mobile_phone' => null,
                'address' => null,
            ],
        ]);
        $internal = Internal::create([
            'user_id' => $userInternal->id,
            'creator_id' => 2,
            'instansi_id' => $instansiInternal->id,
            'nip' => '201828010014',
            'kedeputian' => 'BPTT',
            'pangkat' => 'Kepala BELS'
        ]);

        #-- mitra
        $userMitra = User::create([
            'name' => 'Mitra',
            'email' => 'mitra@gmai.com',
            'email_verified' => 1,
            'email_verified_at' => now(),
            'username' => 'mitra',
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
            'general' => [
                'city' => null,
                'description' => null,
            ],
            'additional_name' => [
                'first_name' => null,
                'sur_name' => null,
                'middle_name' => null,
                'alternate_name' => null,
            ],
            'optional' => [
                'web_page' => null,
                'icq_number' => null,
                'skype_id' => null,
                'aim_id' => null,
                'yahoo_id' => null,
                'msn_id' => null,
                'id_number' => null,
                'institution' => null,
                'departement' => null,
                'phone' => null,
                'mobile_phone' => null,
                'address' => null,
            ],
        ]);
        $mitra = Mitra::create([
            'user_id' => $userMitra->id,
            'creator_id' => 2,
            'instansi_id' => $instansiMitra->id,
            'nip' => '201828010014',
            'kedeputian' => 'CAA',
            'pangkat' => 'Kepala CAA'
        ]);

        #-- instruktur
        $userInstruktur = User::create([
            'name' => 'Instruktur',
            'email' => 'instruktur@gmai.com',
            'email_verified' => 1,
            'email_verified_at' => now(),
            'username' => 'instruktur',
            'password' => Hash::make('admin123'),
            'active' => 1,
            'active_at' => now(),
            'photo' => [
                'filename' => null,
                'description' => null,
            ],
        ]);
        $userInstruktur->assignRole('instruktur_internal');
        $informasiInstruktur = UserInformation::create([
            'user_id' => $userInstruktur->id,
            'general' => [
                'city' => null,
                'description' => null,
            ],
            'additional_name' => [
                'first_name' => null,
                'sur_name' => null,
                'middle_name' => null,
                'alternate_name' => null,
            ],
            'optional' => [
                'web_page' => null,
                'icq_number' => null,
                'skype_id' => null,
                'aim_id' => null,
                'yahoo_id' => null,
                'msn_id' => null,
                'id_number' => null,
                'institution' => null,
                'departement' => null,
                'phone' => null,
                'mobile_phone' => null,
                'address' => null,
            ],
        ]);
        $instruktur = Instruktur::create([
            'user_id' => $userInstruktur->id,
            'creator_id' => 2,
            'nip' => '201828010014',
            'unit_kerja' => 'BPPT',
            'kedeputian' => 'BPPT',
            'pangkat' => 'Pengajar'
        ]);

        #-- peserta
        $userPeserta = User::create([
            'name' => 'Peserta',
            'email' => 'peserta@gmai.com',
            'email_verified' => 1,
            'email_verified_at' => now(),
            'username' => 'peserta',
            'password' => Hash::make('admin123'),
            'active' => 1,
            'active_at' => now(),
            'photo' => [
                'filename' => null,
                'description' => null,
            ],
        ]);
        $userPeserta->assignRole('peserta_internal');
        $informasiPeserta = UserInformation::create([
            'user_id' => $userPeserta->id,
            'general' => [
                'city' => null,
                'description' => null,
            ],
            'additional_name' => [
                'first_name' => null,
                'sur_name' => null,
                'middle_name' => null,
                'alternate_name' => null,
            ],
            'optional' => [
                'web_page' => null,
                'icq_number' => null,
                'skype_id' => null,
                'aim_id' => null,
                'yahoo_id' => null,
                'msn_id' => null,
                'id_number' => null,
                'institution' => null,
                'departement' => null,
                'phone' => null,
                'mobile_phone' => null,
                'address' => null,
            ],
        ]);
        $peserta = Peserta::create([
            'user_id' => $userPeserta->id,
            'creator_id' => 2,
            'nip' => '201828010014',
            'unit_kerja' => 'BPPT',
            'kedeputian' => 'BPPT',
            'pangkat' => 'Peserta'
        ]);
    }
}
