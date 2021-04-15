<?php

namespace App\Providers;

use App\Events\ActivitySaved;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\ForumSaved;
use App\Events\ProgramEnrollEvent;
use App\Events\ReplySaved;
use App\Listeners\GiveBadge;
use App\Listeners\GivePoint;
use App\Listeners\GivePostBadge;
use App\Listeners\GiveReplyBadge;
use App\Listeners\SaveActivityDate;
use App\Listeners\SaveCourseData;
use App\Listeners\SendProgramNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ActivitySaved::class => [
            GivePoint::class,
            GiveBadge::class,
            SaveCourseData::class,
        ],
        ForumSaved::class => [
            GivePostBadge::class,
        ],
        ReplySaved::class => [
            GiveReplyBadge::class,
        ],
        ProgramEnrollEvent::class => [
            SendProgramNotification::class,
        ],

        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\Users\LatestLogin',
        ],
        'Illuminate\Auth\Events\Logout' => [
            'App\Listeners\Users\PreviousLogin',
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
