<?php

namespace App\Providers;

use App\Events\AnswerCreated;
use App\Events\UserCreated;
use App\Listeners\GenerateUserAvatar;
use App\Listeners\SendAnsweredNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        AnswerCreated::class => [
            SendAnsweredNotification::class
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserCreated::class => [
            GenerateUserAvatar::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();
    }
}
