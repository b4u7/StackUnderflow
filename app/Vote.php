<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Vote
 *
 * @property int $id
 * @property int $user_id
 * @property int $vote
 * @property int $votable_id
 * @property string $votable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $votable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereVotableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereVotableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereVote($value)
 * @mixin \Eloquent
 */
class Vote extends Model
{
    public function votable()
    {
        return $this->morphTo();
    }
}
