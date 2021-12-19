<?php

namespace App\Channels;

use App\Events\BroadcastableNoticationEvent;
use App\Models\User;
use Illuminate\Notifications\Notification;

class PusherChannel
{
    /**
     * Send the given notification.
     */
    public function send(mixed $notifiable, Notification $notification)
    {
        if (!$notifiable instanceof User) {
            return;
        }

        $notificationData = $notification->toPusher($notifiable);

        BroadcastableNoticationEvent::dispatch(
            $notifiable,
            $notificationData['title'],
            $notificationData['author'],
            $notificationData['body'],
            $notificationData['url']
        );
    }
}
