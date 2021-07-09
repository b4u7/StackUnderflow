<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'question_id'
    ];

    public function user()
    {
        $this->hasOne(User::class);
    }

    public function question()
    {
        $this->hasOne(Question::class);
    }
}
