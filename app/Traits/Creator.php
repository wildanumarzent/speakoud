<?php

namespace App\Traits;

use App\Observers\CreatorObserver;

trait Creator
{
    public static function bootCreator()
    {
        static::observe(CreatorObserver::class);
    }
}
