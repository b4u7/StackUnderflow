<?php

namespace App\Policies;

use App\Answer;
use App\Question;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnswerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any answers.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the answer.
     *
     * @param User $user
     * @param Answer $answer
     * @return mixed
     */
    public function view(?User $user, Answer $answer)
    {
        return true;
    }

    /**
     * Determine whether the user can create answers.
     *
     * @param User $user
     * @param Question $question
     * @return mixed
     */
    public function create(User $user, Question $question)
    {
        return Answer::where('user_id', '=', $user->id)
                ->where('question_id', '=', $question->id)
                ->where('deleted_at', '=', null)
                ->count() === 0;
    }

    /**
     * Determine whether the user can update the answer.
     *
     * @param User $user
     * @param Answer $answer
     * @return mixed
     */
    public function update(User $user, Answer $answer)
    {
        return $answer->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the answer.
     *
     * @param User $user
     * @param Answer $answer
     * @return mixed
     */
    public function delete(User $user, Answer $answer)
    {
        return $answer->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the answer.
     *
     * @param User $user
     * @param Answer $answer
     * @return mixed
     */
    public function restore(User $user, Answer $answer)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the answer.
     *
     * @param User $user
     * @param Answer $answer
     * @return mixed
     */
    public function forceDelete(User $user, Answer $answer)
    {
        return false;
    }

    /**
     * Determine whether the user is an admin.
     *
     * @param User $user
     * @param $ability
     * @return bool
     */
    public function before(User $user, $ability) {
        if ($user->admin && $ability !== 'create') {
            return true;
        }

        return null;
    }
}
