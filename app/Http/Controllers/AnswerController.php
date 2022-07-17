<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerStoreRequest;
use App\Http\Requests\AnswerUpdateRequest;
use App\Models\Answer;
use App\Models\Question;
use Auth;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class AnswerController extends Controller
{
    public function index(Request $request, Question $question): CursorPaginator
    {
        $user = $request->user();

        return $question->answers()
            ->with('user')
            ->withSum('votes', 'vote')
            ->when(
                $user,
                static fn(Builder $query) => $query->withSum(
                    ['votes as user_vote' => static fn(Builder $q) => $q->where('user_id', '=', $user?->id)],
                    'vote'
                )
            )
            ->when($user !== null && $user->admin, static fn(Builder $q) => $q->withTrashed())
            ->when(
                $question->solution_id !== null,
                static fn(Builder $q) => $q->orderByDesc(DB::raw('id = ' . $question->solution_id))
            )
            ->cursorPaginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws AuthorizationException
     */
    public function store(AnswerStoreRequest $request, Question $question): RedirectResponse
    {
        $this->authorize('create', [Answer::class, $question]);

        Answer::create([
            'user_id' => Auth::id(),
            'question_id' => $question->id,
            ...$request->validated()
        ]);

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @throws AuthorizationException
     */
    public function edit(Request $request, Question $question, Answer $answer): Response
    {
        $this->authorize('update', $answer);

        return Inertia::render('Questions/Answers/Edit', ['question' => $question, 'answer' => $answer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws AuthorizationException
     */
    public function update(AnswerUpdateRequest $request, Question $question, Answer $answer): RedirectResponse
    {
        $this->authorize('update', $answer);

        $answer->update($request->validated());

        return redirect()->route('questions.show', [$question]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws AuthorizationException
     * @throws Exception
     */
    public function destroy(Question $question, Answer $answer): RedirectResponse
    {
        $this->authorize('delete', $answer);

        DB::transaction(function () use ($question, $answer) {
            $answer->delete();

            $question->solution()->dissociate()->save();
        });

        return back();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @throws AuthorizationException
     */
    public function restore(Question $question, Answer $answer): RedirectResponse
    {
        $this->authorize('restore', $answer);

        $answer->restore();

        return back();
    }

    /**
     * Upvotes the current answer.
     *
     * @throws Exception
     */
    public function upvote(Question $question, Answer $answer): RedirectResponse
    {
        $this->authorize('vote', $answer);

        $find = $answer->votes()->where([
            'user_id' => Auth::id(),
            'votable_id' => $answer->id,
            'votable_type' => Answer::class,
            'vote' => 1
        ])->first();

        if ($find) {
            $find->delete();
            return back();
        }

        $answer->votes()->updateOrCreate(
            [
                'user_id' => Auth::id(),
                'votable_id' => $answer->id,
                'votable_type' => Answer::class
            ],
            [
                'vote' => 1
            ]
        );

        return back();
    }

    /**
     * Downvotes the current answer.
     *
     * @throws Exception
     */
    public function downvote(Question $question, Answer $answer): RedirectResponse
    {
        $this->authorize('vote', $answer);

        $find = $answer->votes()->where([
            'user_id' => Auth::id(),
            'votable_id' => $answer->id,
            'votable_type' => Answer::class,
            'vote' => -1
        ])->first();

        if ($find) {
            $find->delete();
            return back();
        }

        $answer->votes()->updateOrCreate(
            [
                'user_id' => Auth::id(),
                'votable_id' => $answer->id,
                'votable_type' => Answer::class
            ],
            [
                'vote' => -1
            ]
        );

        return back();
    }

    /**
     * Sets the current answer as a solution.
     *
     * @throws AuthorizationException
     */
    public function solution(Question $question, Answer $answer): RedirectResponse
    {
        $this->authorize('solution', $answer);

        if ($question->solution()->is($answer)) {
            $question->solution()->dissociate()->save();

            return back();
        }

        $question->solution()->associate($answer)->save();

        return back();
    }
}
