<?php

use App\Models\Users\User;
use App\Models\Users\UserInformation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            0 => [
                'name' => 'Developer 4VM',
                'email' => 'super@gmail.com',
                'email_verified' => 1,
                'email_verified_at' => now(),
                'username' => '4vmdev',
                'password' => Hash::make('myDev4vm#'),
                'active' => 1,
                'active_at' => now(),
                'roles' => 'developer',
            ],
            1 => [
                'name' => 'Administrator',
                'email' => 'administrator@gmail.com',
                'email_verified' => 1,
                'email_verified_at' => now(),
                'username' => 'administrator',
                'password' => Hash::make('admin123'),
                'active' => 1,
                'active_at' => now(),
                'roles' => 'administrator',
            ],
        ];

        foreach ($users as $key) {
            $user = User::create([
                'name' => $key['name'],
                'email' => $key['email'],
                'email_verified' => $key['email_verified'],
                'email_verified_at' => $key['email_verified_at'],
                'username' => $key['username'],
                'password' => $key['password'],
                'active' => $key['active'],
                'active_at' => $key['active_at'],
                'photo' => [
                    'filename' => null,
                    'description' => null,
                ],
            ]);

            $user->assignRole($key['roles']);

            $information = UserInformation::create([
                'user_id' => $user->id,
                'place_of_birthday' => null,
                'date_of_birthday' => null,
                'gender' => null,
                'city' => null,
                'description' => null,
                'phone' => null,
                'address' => null,
            ]);
        }
    }
}
