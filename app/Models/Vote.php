<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Vote extends Model
{
    use HasFactory;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'user_id', 'vote'
    ];

    /**
     * @return MorphTo<Question|Answer|Model, Vote>
     */
    public function votable(): MorphTo
    {
        return $this->morphTo();
    }
}
