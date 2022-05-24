<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;

class SoftDeleteDisreputableVotable implements ShouldQueue
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
    public function handle(object $event): void
    {
        if ($event->vote->votable->votes()->sum('vote') <= -30) {
            $event->vote->votable->delete();
        }
    }
}
