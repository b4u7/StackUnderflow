<?php

namespace App\Models;

use App\Scopes\AdminScope;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
     * @var array<string>
     */
    protected $withCount = ['views'];

    public static function booted()
    {
        static::addGlobalScope(new AdminScope);
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
     * @return HasMany<Bookmark>
     */
    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
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
}
