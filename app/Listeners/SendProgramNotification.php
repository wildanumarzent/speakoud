<?php

namespace App\Listeners;

use App\Events\ProgramEnrollEvent;
use App\Mail\SendEnrollProgramNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
class SendProgramNotification implements ShouldQueue
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
     * @param  ProgramEnrollEvent  $event
     * @return void
     */
    public function handle(ProgramEnrollEvent $event)
    {
        $email = $event->peserta->peserta->user->email;
        //Send Mail with a  mailable class
        Mail::to($email)->send(new SendEnrollProgramNotification($event));
    }
}
