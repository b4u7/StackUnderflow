<?php

namespace App\Models;

use App\Scopes\AdminScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public static function booted() {
        static::addGlobalScope(new AdminScope());
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
