<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'user_id', 'vote'
    ];

    public function votable()
    {
        return $this->morphTo();
    }
}
