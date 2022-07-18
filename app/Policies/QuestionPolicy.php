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
        return ($user?->admin ?? false) || !$question->trashed();
    }

    /**
     * Determine whether the user can create questions.
     */
    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    /**
     * Determine whether the user can update the question.
     */
    public function update(User $user, Question $question): bool
    {
        return $user->admin || $question->user()->is($user);
    }

    /**
     * Determine whether the user can delete the question.
     */
    public function delete(User $user, Question $question): bool
    {
        if ($question->trashed()) {
            return false;
        }

        return $user->admin || $question->user()->is($user);
    }

    /**
     * Determine whether the user can restore the question.
     */
    public function restore(User $user, Question $question): bool
    {
        return $user->admin && $question->trashed();
    }

    /**
     * Determine whether the user can permanently delete the question.
     */
    public function forceDelete(User $user, Question $question): bool
    {
        return false;
    }

    /*
     * Determine whether the user can bookmark the question.
     */
    public function bookmark(User $user, Question $question): bool
    {
        if ($question->trashed()) {
            return false;
        }

        return !$question->bookmarkedBy()->whereKey($user->id)->exists();
    }

    /*
     * Determine whether the user can unbookmark the question.
     */
    public function unbookmark(User $user, Question $question): bool
    {
        if ($question->trashed()) {
            return false;
        }

        return !$question->trashed() && $question->bookmarkedBy()->whereKey($user->id)->exists();
    }

    /**
     * Determine whether the user can vote on the question.
     */
    public function vote(User $user, Question $question): bool
    {
        if ($question->trashed()) {
            return false;
        }

        return $question->user()->is($user);
    }
}
