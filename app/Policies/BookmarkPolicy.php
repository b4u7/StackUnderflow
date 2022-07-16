<?php

namespace App\Policies;

use App\Models\Bookmark;
use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookmarkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create the model.
     */
    public function create(User $user, Question $question): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Bookmark $bookmark): bool
    {
        return $user->id === $bookmark->user_id;
    }
}
