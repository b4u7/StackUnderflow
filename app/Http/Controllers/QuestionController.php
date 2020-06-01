<?php

namespace App\Http\Controllers;

use Auth;
use Exception;
use App\Answer;
use App\Question;
use App\Vote;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class QuestionController extends Controller
{
    /**
     * QuestionController constructor.
     */
    public function __construct()
    {
        // $this->authorizeResource(Question::class, 'question');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Question::class);

        $questions = Question::take(10)->get();

        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Question::class);

        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', Question::class);

        $question = Question::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'user_id' => Auth::id()
        ]);

        return redirect()->route('questions.show', [$question]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $questionId
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function show(int $questionId)
    {
        $question = Question::addSelect([
            'votes_sum' =>
                Vote::selectRaw('SUM(vote)')
                    ->where('votable_type', '=', Question::class)
                    ->whereColumn('votable_id', 'questions.id')
        ])->with(['votes', 'user'])
            ->where('id', '=', $questionId)
            ->first();

        $this->authorize('view', $question);

        $answers = Answer::addSelect([
            'votes_sum' =>
                Vote::selectRaw('SUM(vote)')
                    ->where('votable_type', '=', Answer::class)
                    ->whereColumn('votable_id', 'answers.id')
        ])->with(['votes', 'user'])
            ->where('question_id', '=', $questionId)
            ->get()
            ->sortByDesc('votes_sum');

        return view('questions.show', compact('question', 'answers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Question $question
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Question $question)
    {
        $this->authorize('edit', $question);

        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Question $question
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, Question $question)
    {
        $this->authorize('edit', $question);

        $question->update($request->all());

        return redirect()->route('questions.show', [$question->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Question $question)
    {
        $this->authorize('delete', $question);

        $question->delete();

        return redirect()->route('questions.index');
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param Question $question
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function restore(Question $question)
    {
        $this->authorize('restore', $question);

        $question->restore();

        return redirect()->back();
    }

    /**
     * Upvotes the current question.
     *
     * @param Question $question
     * @return RedirectResponse
     *
     */
    public function upvote(Question $question)
    {
        $question->votes()->updateOrCreate(
            [
                'user_id' => Auth::id(),
                'votable_id' => $question->id,
                'votable_type' => Question::class
            ],
            [
                'vote' => 1
            ]
        );

        return redirect()->back();
    }

    /**
     * Downvotes the current question.
     *
     * @param Question $question
     * @return RedirectResponse
     */
    public function downvote(Question $question)
    {
        $question->votes()->updateOrCreate(
            [
                'user_id' => Auth::id(),
                'votable_id' => $question->id,
                'votable_type' => Question::class
            ],
            [
                'vote' => -1
            ]
        );

        return redirect()->back();
    }
}
