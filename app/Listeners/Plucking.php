<?php

namespace App\Listeners;

use App\Events\Pluck;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class Plucking
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
     * @param  object  $event
     * @return void
     */
    public function handle(Pluck $event)
    {
        if( $event->message instanceof MustVerifyEmail && ! $event->message->HasVerified())
        {
            $event->message->sendEmailVerificationNotification();
        }
    }
}
