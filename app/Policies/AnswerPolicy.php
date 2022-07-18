<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AnswerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any answers.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the answer.
     */
    public function view(?User $user, Answer $answer): bool
    {
        return ($user?->admin ?? false) || !$answer->trashed();
    }

    /**
     * Determine whether the user can create answers.
     */
    public function create(User $user, Question $question): Response|bool
    {
        if (!$user->hasVerifiedEmail()) {
            return $this->deny('You must verify your email address before you can answer questions.');
        }

        if ($question->trashed()) {
            return false;
        }

        return $question->answers()
            ->whereBelongsTo($user)
            ->doesntExist();
    }

    /**
     * Determine whether the user can update the answer.
     */
    public function update(User $user, Answer $answer): bool
    {
        return $user->admin || $answer->user()->is($user);
    }

    /**
     * Determine whether the user can delete the answer.
     */
    public function delete(User $user, Answer $answer): bool
    {
        if ($answer->trashed()) {
            return false;
        }

        return $user->admin || $answer->user()->is($user);
    }

    /**
     * Determine whether the user can restore the answer.
     */
    public function restore(User $user, Answer $answer): bool
    {
        return $user->admin && $answer->trashed();
    }

    /**
     * Determine whether the user can permanently delete the answer.
     */
    public function forceDelete(User $user, Answer $answer): bool
    {
        return false;
    }

    /**
     * Determine whether the user can vote on the answer.
     */
    public function vote(User $user, Answer $answer): bool
    {
        if ($answer->question === null) {
            dd($answer);
        }

        return !$answer->trashed() && !$answer->question->trashed();
    }

    /**
     * Determine whether the user can select the answer as the solution.
     */
    public function solution(User $user, Answer $answer): bool
    {
        if ($answer->trashed() || $answer->question->trashed()) {
            return false;
        }

        return $user->id === $answer->question->user_id;
    }
}
