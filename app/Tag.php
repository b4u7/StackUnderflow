<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }
}
