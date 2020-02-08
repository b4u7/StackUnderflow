<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function comments()
    {
        $this->morphMany(Comment::class, 'commentable');
    }

    public function votes()
    {
        $this->morphMany(Vote::class, 'votable');
    }
}
