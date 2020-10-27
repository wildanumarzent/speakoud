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
            'admin_web',
            'mitra',
            'guru_internal',
            'guru_mitra',
            'murid_internal',
            'murid_mitra'
        ];

        foreach ($roles as $key) {
            Role::create([
                'name' => $key,
                'guard_name' => 'web',
            ]);
        }
    }
}
