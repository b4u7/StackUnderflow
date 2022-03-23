<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

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
        return true;
    }

    /**
     * Determine whether the user can create answers.
     */
    public function create(User $user, Question $question): bool
    {
        return Answer::where('user_id', '=', $user->id)
                ->where('question_id', '=', $question?->id)
                ->where('deleted_at', '=', null)
                ->count() === 0;
    }

    /**
     * Determine whether the user can update the answer.
     */
    public function update(User $user, Answer $answer): bool
    {
        return $answer->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the answer.
     */
    public function delete(User $user, Answer $answer): bool
    {
        return $answer->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the answer.
     */
    public function restore(User $user, Answer $answer): bool
    {
        return false;
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
        return true;
    }

    /**
     * Determine whether the user can select the answer as the solution.
     */
    public function solution(User $user, Answer $answer): bool
    {
        return $user->id === $answer->question->user_id;
    }

    /**
     * Determine whether the user is an admin.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->admin && $ability !== 'create') {
            return true;
        }

        return null;
    }
}
