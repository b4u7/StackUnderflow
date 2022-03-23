<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any questions.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the question.
     */
    public function view(?User $user, Question $question): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create questions.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the question.
     */
    public function update(User $user, Question $question): bool
    {
        return $user->id === $question->user_id;
    }

    /**
     * Determine whether the user can delete the question.
     */
    public function delete(User $user, Question $question): void
    {
        //
    }

    /**
     * Determine whether the user can restore the question.
     */
    public function restore(User $user, Question $question): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the question.
     */
    public function forceDelete(User $user, Question $question): bool
    {
        return false;
    }

    /**
     * Determine whether the user can vote on the question.
     */
    public function vote(User $user, Question $question): bool
    {
        return $user->id !== $question->user_id;
    }

    /**
     * Determine whether the user is an admin.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->admin) {
            return true;
        }

        return null;
    }
}
