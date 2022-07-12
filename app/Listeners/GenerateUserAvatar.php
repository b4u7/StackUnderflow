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
        $user = $event->user;

        $avatar = Avatar::create($user->name)->getImageObject()->stream('jpeg');
        $avatarHash = md5($avatar);

        Storage::cloud()->put("users/avatars/{$user->id}.jpeg", $avatar, 'public');
        $user->update(['avatar_hash' => $avatarHash]);
    }
}
