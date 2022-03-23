<?php

namespace App\Models;

use App\Scopes\AdminScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasFactory;

    public static function booted() {
        static::addGlobalScope(new AdminScope());
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
