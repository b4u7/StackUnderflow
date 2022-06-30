<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Support\Facades\Storage;
use Laravolt\Avatar\Facade as Avatar;

class GenerateUserAvatar
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
     */
    public function handle(UserCreated $event): void
    {
        $avatar = Avatar::create($event->user->name)->getImageObject()->stream('jpeg');

        Storage::disk('public')->put("users/avatars/{$event->user->id}.jpeg", $avatar);
    }
}
