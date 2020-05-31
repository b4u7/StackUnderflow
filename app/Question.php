<?php

namespace App;

use App\Scopes\AdminScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Question extends Model
{
    use Searchable, SoftDeletes;

    protected $fillable = [
        'title', 'body', 'user_id'
    ];

    public static function booted() {
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

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }
}
