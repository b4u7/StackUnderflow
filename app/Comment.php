<?php

namespace App;

use App\Scopes\AdminScope;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public static function booted() {
        static::addGlobalScope(new AdminScope());
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
