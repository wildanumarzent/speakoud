<?php

use App\Models\Inquiry\Inquiry;
use Illuminate\Database\Seeder;

class InquirySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Inquiry::create([
            'name' => 'Kontak',
            'slug' => 'kontak',
            'body' => '<h1>BPPT E-Learning System</h1>',
            'after_body' => '<h4>Thanks For your Feedback</h4>',
            'publish' => 1,
            'show_form' => 1,
            'show_map' => 1,
            'latitude' => '-6.185009',
            'longitude' => '106.821806',
        ]);
    }
}
