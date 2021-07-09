<?php

namespace App\Models;

use App\Scopes\AdminScope;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Question extends Model implements Viewable
{
    use Searchable, SoftDeletes, InteractsWithViews, HasFactory;

    public $removeViewsOnDelete = false;

    protected $fillable = [
        'title', 'body', 'user_id'
    ];

    protected $withCount = ['views'];

    public static function booted()
    {
        static::addGlobalScope(new AdminScope);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }
}
