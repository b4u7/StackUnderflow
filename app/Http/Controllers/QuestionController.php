<?php

namespace App\Http\Controllers;

use Auth;
use App\Answer;
use App\Question;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use \Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use \Exception;

class QuestionController extends Controller
{
    /**
     * QuestionController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Question::class, 'question');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $questions = Question::take(10)->get();

        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
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
     * @param Question $question
     * @return Factory|View
     */
    public function show(Question $question)
    {
        $answers = Answer::withCount(['votes'])
            ->with(['votes', 'user'])
            ->where('question_id', '=', $question->id)
            ->get();

        return view('questions.show', compact('question', 'answers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Question $question
     * @return View
     */
    public function edit(Question $question)
    {
        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Question $question
     * @return RedirectResponse
     */
    public function update(Request $request, Question $question)
    {
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
        $question->delete();

        return redirect()->route('questions.index');
    }
}
