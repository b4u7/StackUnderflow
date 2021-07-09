<?php

namespace App\Events;

use App\Answer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserAnswered implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $afterCommit = true;

    /**
     * The answer instance.
     *
     * @var \App\Answer
     */
    public $answer;

    /**
     * Create a new event instance.
     *
     * @param \App\Answer $answer
     * @return void
     */
    public function __construct(Answer $answer)
    {
        $this->answer = $answer;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // TODO: Ask what's the appropriate channel :) for now let's use this and not worry too much about it
//        return new PrivateChannel('questions.answers.' . $this->answer->id);
        return new Channel('questions.answers');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->answer->id,
            'user' => $this->answer->user,
            'answer' => $this->answer->body
        ];
    }
}
