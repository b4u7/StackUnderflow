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
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user, Question $question)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Bookmark $bookmark
     * @return mixed
     */
    public function delete(User $user, Bookmark $bookmark)
    {
        return $user->id === $bookmark->user_id;
    }

    /**
     * Determine whether the user is an admin.
     *
     * @param User $user
     * @return bool
     */
    public function before(User $user)
    {
        if ($user->admin) {
            return true;
        }

        return null;
    }
}
