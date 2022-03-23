<?php

namespace App\Listeners;

use App\Events\AnswerCreated;
use App\Notifications\AnsweredNotification;
use Illuminate\Support\Facades\Notification;

class SendAnsweredNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(AnswerCreated $event): void
    {
        $user = $event->answer->question->user;

        Notification::send($user, new AnsweredNotification($event->answer));
    }
}
