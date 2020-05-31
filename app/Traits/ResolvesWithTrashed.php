<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin SoftDeletes
 */
trait ResolvesWithTrashed
{
    public function resolveRouteBinding($value, $field = null)
    {
        return static::withTrashed()->where($field ?? static::getKeyName(), '=', $value)->first();
    }
}
