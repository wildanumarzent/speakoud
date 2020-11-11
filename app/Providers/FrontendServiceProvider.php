<?php

namespace App\Providers;

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
                'banner_default' => '',
                //group 2
                'website_name' => 'BPPT E-Learning System',
                'address' => '',
                'email' => '',
                'email_2' => '',
                'fax' => '',
                'phone' => '',
                'phone_2' => '',
                //group 3
                'meta_title' => 'BPPT E-Learning System',
                'meta_description' => '',
                'meta_keywords' => '',
                'google_analytics' => '',
                'google_verification' => '',
                'domain_verification' => ''
            ],
        ]);
    }
}
