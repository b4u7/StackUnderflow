<?php

namespace App\Models;

use App\Scopes\AdminScope;
use App\Services\MarkdownRenderer;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;

class Question extends Model implements Viewable
{
    use Searchable, SoftDeletes, InteractsWithViews, HasFactory;

    public bool $removeViewsOnDelete = false;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'title', 'body', 'user_id'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<string>
     */
    protected $appends = [
        'html_body', 'stripped_body'
    ];

    /**
     * @var array<string>
     */
    protected $withCount = ['views'];

    public static function booted()
    {
        static::addGlobalScope(new AdminScope);

        static::addGlobalScope('votes_sum', fn(Builder $query) => $query->selectSub(fn($query) => $query
            ->selectRaw('coalesce(sum(vote), 0)')
            ->from('votes')
            ->where('votable_id', '=', DB::raw('questions.id'))
            ->where('votable_type', '=', Question::class),
            'votes_sum_vote'
        ));
    }

    /**
     * @return BelongsTo<User, Question>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany<Tag>
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * @return HasMany<Answer>
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * @return MorphMany<Comment>
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * @return BelongsToMany<User>
     */
    public function bookmarkedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_question_bookmark')->using(Bookmark::class);
    }

    /**
     * @return MorphMany<Vote>
     */
    public function votes(): MorphMany
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    /**
     * @return BelongsTo<Answer, Question>
     */
    public function solution(): BelongsTo
    {
        return $this->belongsTo(Answer::class);
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
