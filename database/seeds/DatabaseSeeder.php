<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(Temp::class);
        
        $this->call([
            RoleSeeder::class,
            JabatanSeeder::class,
            UserSeeder::class,
            GradesSeeder::class,
            KonfigurasiSeeder::class,
            PageSeeder::class,
            BannerSeeder::class,
            InquirySeeder::class,
            // AddonSeeder::class,
        ]);
    }
}
