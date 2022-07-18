<?php

namespace App\Models;

use App\Scopes\AdminScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new AdminScope());
    }

    /**
     * @return MorphTo<Answer|Model, Comment>
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
