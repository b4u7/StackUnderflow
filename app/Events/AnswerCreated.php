<?php

namespace App\Events;

use App\Models\Answer;
use Illuminate\Contracts\Queue\ShouldQueue;

class AnswerCreated implements ShouldQueue
{
    /**
     * Create a new event instance.
     */
    public function __construct(public Answer $answer)
    {
    }
}
