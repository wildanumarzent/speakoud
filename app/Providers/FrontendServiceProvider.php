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
                'website_name' => 'BPPT E-Learning System',
                'banner_default' => '',
                //group 2
                'meta_title' => 'BPPT E-Learning System',
                'meta_description' => '',
                'meta_keywords' => '',
            ],
        ]);
    }
}
