<?php

namespace App\Models;

use App\Events\AnswerCreated;
use App\Scopes\AdminScope;
use App\Services\MarkdownRenderer;
use App\Traits\ResolvesWithTrashed;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<string>
     */
    protected $appends = [
        'html_body', 'stripped_body'
    ];

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new AdminScope);
    }

    /**
     * @return BelongsTo<User, Answer>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Question, Answer>
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class)->withTrashed();
    }

    /**
     * @return MorphMany<Comment>
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * @return MorphMany<Vote>
     */
    public function votes(): MorphMany
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    protected function htmlBody(): Attribute
    {
        return Attribute::get(fn() => app(MarkdownRenderer::class)->render($this->body))->shouldCache();
    }

    protected function strippedBody(): Attribute
    {
        return Attribute::get(fn() => strip_tags($this->html_body));
    }
}
