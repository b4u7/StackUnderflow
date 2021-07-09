<?php

namespace App\Listeners;

use App\Events\UserAnswered;

class SendAnsweredNotification
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
     * @param  UserAnswered  $event
     * @return void
     */
    public function handle(UserAnswered $event)
    {
        // Access the answer using $event->answer...
    }
}
