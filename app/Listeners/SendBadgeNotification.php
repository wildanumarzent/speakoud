<?php

namespace App\Listeners;

use App\Events\BadgeSaved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendBadgeNotification
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
        //
    }
}
