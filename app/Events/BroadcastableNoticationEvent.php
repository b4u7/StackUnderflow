<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class BroadcastableNoticationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, Queueable;

    /**
     * Create a new event instance.
     */
    public function __construct(public User $user, public string $title, public string $body, public string $url)
    {
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('notifications.' . $this->user->id);
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'notification.received';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'userId' => $this->user->id,
            'title' => $this->title,
            'body' => $this->body,
            'url' => $this->url
        ];
    }
}
