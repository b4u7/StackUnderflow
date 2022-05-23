<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Bookmark extends Pivot
{
    use HasFactory;

    protected $table = 'user_question_bookmark';
}
