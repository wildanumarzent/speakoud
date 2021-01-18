<?php

namespace App\Listeners;

use App\Events\BadgeSaved;
use App\Mail\BadgeAchievedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendBadgeNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BadgeSaved  $event
     * @return void
     */
    public function handle(BadgeSaved $event)
    {
        $email = $event->badge->peserta->user->email;
        Mail::to($email)->send(new BadgeAchievedNotification($event));
    }
}
