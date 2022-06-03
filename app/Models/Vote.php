<?php

namespace App\Models;

use App\Events\VoteCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Vote extends Model
{
    use HasFactory;

    protected $dispatchesEvents = ['created' => VoteCreated::class];

    /**
     * @var array<string>
     */
    protected $fillable = [
        'user_id', 'vote'
    ];

    /**
     * @var array<string>
     */
    protected $touches = [
        'votable'
    ];

    /**
     * @return MorphTo<Question|Answer|Model, Vote>
     */
    public function votable(): MorphTo
    {
        return $this->morphTo();
    }
}
