<?php

namespace App\Providers;

use App\Models\Banner\BannerKategori;
use App\Models\Course\ProgramPelatihan;
use App\Models\Konfigurasi;
use App\Models\Page;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class FrontendServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::share([
            'configuration' => [
                //group 1
                'banner_default' => Konfigurasi::banner(),
                //group 2
                'website_name' => Konfigurasi::value('website_name'),
                'address' => Konfigurasi::value('address'),
                'email' => Konfigurasi::value('email'),
                'email_2' => Konfigurasi::value('email_2'),
                'fax' => Konfigurasi::value('fax'),
                'phone' => Konfigurasi::value('phone'),
                'phone_2' => Konfigurasi::value('phone_2'),
                //group 3
                'meta_title' => Konfigurasi::value('meta_title'),
                'meta_description' => Konfigurasi::value('meta_description'),
                'meta_keywords' => Konfigurasi::value('meta_keywords'),
                'google_analytics' => Konfigurasi::value('google_analytics'),
                'google_verification' => Konfigurasi::value('google_verification'),
                'domain_verification' => Konfigurasi::value('domain_verification'),
                //group 4
                'twitter' => Konfigurasi::value('twitter'),
                'youtube' => Konfigurasi::value('youtube'),
                'facebook' => Konfigurasi::value('facebook'),
                'linkedin' => Konfigurasi::value('linkedin'),
                'whatsapp' => Konfigurasi::value('whatsapp'),
                'app_store' => Konfigurasi::value('app_store'),
                'instagram' => Konfigurasi::value('instagram'),
                'pinterst' => Konfigurasi::value('pinterst'),
                'google_plus' => Konfigurasi::value('google_plus'),
                'google_play_store' => Konfigurasi::value('google_play_store'),
            ],
            'menu' => [
                'program_pelatihan' => ProgramPelatihan::where('publish', 1)
                    ->orderBy('urutan', 'ASC')->get(),
            ],
            'pages' => [
                'quick_link' => Page::where('publish', 1)->whereIn('id', [2,3,4])->get(),
                'layanan' => Page::where('publish', 1)->whereIn('id', [5,6])->get(),
            ],
            'banner' => [
                'login' => BannerKategori::where('id', 2)->get(),
            ],
        ]);
    }
}
