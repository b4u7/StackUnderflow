<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Auth;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AnswerController extends Controller
{
    // TODO: VALIDATION!!!!
    /**
     * Store a newly created resource in storage.
     *
     * @throws AuthorizationException
     */
    public function store(Request $request, Question $question): RedirectResponse
    {
        $this->authorize('create', [Answer::class, $question]);

        Answer::create([
            'user_id' => Auth::id(),
            'question_id' => $question->id,
            'body' => $request->input('body'),
        ]);

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @throws AuthorizationException
     */
    public function edit(Request $request, Question $question, Answer $answer): \Inertia\Response
    {
        $this->authorize('update', $answer);

        return Inertia::render('questions.answers.edit', compact('question', 'answer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws AuthorizationException
     */
    public function update(Request $request, Question $question, Answer $answer): RedirectResponse
    {
        $this->authorize('update', $answer);

        $answer->update($request->all());

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

        $answer->delete();

        return redirect()->back();
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

        return redirect()->back();
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
            return redirect()->back();
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

        return redirect()->back();
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
            return redirect()->back();
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

        return redirect()->back();
    }

    /**
     * Sets the current answer as a solution.
     *
     * @throws AuthorizationException
     */
    public function solution(Question $question, Answer $answer): RedirectResponse
    {
        $this->authorize('solution', $answer);

        $question->solution = $answer->id;
        $question->save();

        return redirect()->back();
    }
}
