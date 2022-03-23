<?php

namespace App\Models;

use App\Events\AnswerCreated;
use App\Scopes\AdminScope;
use App\Traits\ResolvesWithTrashed;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use SoftDeletes, ResolvesWithTrashed, HasFactory;

    /**
     * @var array<string>
     */
    protected $dispatchesEvents = ['created' => AnswerCreated::class];

    /**
     * @var array<string>
     */
    protected $fillable = [
        'user_id', 'question_id', 'body'
    ];

    public static function boot()
    {
        static::addGlobalScope(new AdminScope);
        parent::boot();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function votes(): MorphMany
    {
        return $this->morphMany(Vote::class, 'votable');
    }
}
