<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'developer',
            'administrator',
            'internal',
            'mitra',
            'instruktur_internal',
            'instruktur_mitra',
            'peserta_internal',
            'peserta_mitra'
        ];

        foreach ($roles as $key) {
            Role::create([
                'name' => $key,
                'guard_name' => 'web',
            ]);
        }
    }
}
