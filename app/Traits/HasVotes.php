<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @mixin Model
 */
trait HasVotes
{
    static protected function bootHasVotes(): void
    {
        self::addGlobalScope('votes_sum',
            fn(Builder $query) => $query->addSelect([
                    'votes_sum_vote' => fn($query) => $query
                        ->selectRaw('coalesce(sum(vote), 0)')
                        ->from('votes')
                        ->where('votable_id', '=', DB::raw((new self)->getQualifiedKeyName()))
                        ->where('votable_type', '=', self::class)
                ]
            ));
    }
}
