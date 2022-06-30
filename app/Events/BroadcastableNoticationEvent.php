<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use JetBrains\PhpStorm\ArrayShape;

class BroadcastableNoticationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, Queueable;

    /**
     * Create a new event instance.
     *
     * @param array<string> $author
     */
    public function __construct(public User $user, public string $title, public array $author, public string $body, public string $url)
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
     *
     * @return array<string, array<string>|int|string>
     */
    #[ArrayShape(['userId' => "int|mixed", 'title' => "string", 'author' => "mixed", 'body' => "string", 'url' => "string"])]
    public function broadcastWith(): array
    {
        return [
            'userId' => $this->user->id,
            'title' => $this->title,
            'author' => $this->author,
            'body' => $this->body,
            'url' => $this->url
        ];
    }
}
