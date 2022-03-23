<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'question_id'
    ];

    /**
     * @return HasOne<User>
     */
    public function user(): hasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * @return HasOne<Question>
     */
    public function question(): hasOne
    {
        return $this->hasOne(Question::class);
    }
}
