<?php

namespace App\Http\Controllers;

use Auth;
use App\Answer;
use App\Question;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnswerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Question $question
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Request $request, Question $question)
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
     * @param Request $request
     * @param Question $question
     * @param Answer $answer
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function edit(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        return view('questions.answers.edit', compact('question', 'answer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Question $question
     * @param Answer $answer
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        $answer->update($request->all());

        return redirect()->route('questions.show', [$question]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @param Answer $answer
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws Exception
     */
    public function destroy(Question $question, Answer $answer)
    {
        $this->authorize('delete', $answer);

        $answer->delete();

        return redirect()->back();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param Question $question
     * @param Answer $answer
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function restore(Question $question, Answer $answer)
    {
        $this->authorize('restore', $answer);

        $answer->restore();

        return redirect()->back();
    }

    /**
     * Upvotes the current answer.
     *
     * @param Question $question
     * @param Answer $answer
     * @return RedirectResponse
     *
     */
    public function upvote(Question $question, Answer $answer)
    {
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
     * @param Question $question
     * @param Answer $answer
     * @return RedirectResponse
     *
     */
    public function downvote(Question $question, Answer $answer)
    {
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
}
