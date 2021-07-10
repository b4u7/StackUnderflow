<?php

namespace App\Http\Controllers;

use Auth;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use App\Models\Answer;
use App\Models\Bookmark;
use App\Models\Question;
use App\Models\Tag;
use App\Models\Vote;

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
     * @return \Inertia\Response
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Question::class);

        // TODO: Change this to be order by votes before demo
        $questions = Question::with(['votes', 'answers', 'user', 'tags'])
            ->withCount('votes')
            ->orderByDesc('id')
            ->paginate(10);

        return Inertia::render('Questions/Index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Question::class);

        return Inertia::render('Questions/Create');
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

        $tagNames = explode(',', $request->input('tags'));
        foreach ($tagNames as $tagName) {
            if (empty(trim($tagName))) {
                continue;
            }

            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $question->tags()->attach($tag);
        }

        return redirect()->route('questions.show', [$question]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $questionId
     * @return \Inertia\Response
     * @throws AuthorizationException
     */
    public function show(int $questionId)
    {
        $question = Question::with([
            'answers' => fn($q) => $q->withSum('votes', 'vote'),
            'answers.user',
            'user',
            'tags',
            'bookmarks'
        ])->withSum('votes', 'vote')
            ->where('id', '=', $questionId)
            ->when(Auth::user() !== null && Auth::user()->admin, function ($query) {
                return $query->withTrashed();
            })
            ->firstOrFail();

        views($question)->record();
        $this->authorize('view', $question);

        $userQuestionVote = Vote::query()
            ->where('votable_type', '=', Question::class)
            ->where('votable_id', '=', $question->id)
            ->where('user_id', '=', Auth::id())
            ->first();

        $userAnswerVotes = (object)Vote::query()
            ->where('votable_type', '=', Answer::class)
            ->whereIn('votable_id', $question->answers->pluck('id'))
            ->where('user_id', '=', Auth::id())
            ->get()
            ->keyBy('votable_id')
            ->toArray();

        $bookmark = optional(Auth::user(), fn($u) => $question->bookmarks()->where('user_id', '=', $u->id))->first();

        $permissions = [
            'question' => [
                'canEdit' => Gate::check('edit', $question),
                'canDelete' => Gate::check('delete', $question),
                'canVote' => Gate::check('vote', $question),
                'canRestore' => Gate::check('restore', $question),
                'canBookmark' => Gate::check('create', [Bookmark::class, $question]),
                'canUnbookmark' => optional($bookmark, fn($b) => Gate::check('delete', $b)) ?? false
            ],
            'answers' => []
        ];

        foreach ($question->answers as $answer) {
            $permissions['answers'][$answer->id]['canEdit'] = Gate::check('edit', $answer);
            $permissions['answers'][$answer->id]['canDelete'] = Gate::check('delete', $answer);
            $permissions['answers'][$answer->id]['canVote'] = Gate::check('vote', $answer);
            $permissions['answers'][$answer->id]['canRestore'] = Gate::check('restore', $question);
        }

        $isTrashed = $question->trashed();

        return Inertia::render('Questions/Show', compact(
            'question',
            'isTrashed',
            'bookmark',
            'userQuestionVote',
            'userAnswerVotes',
            'permissions'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Question $question
     * @return \Inertia\Response
     * @throws AuthorizationException
     */
    public function edit(Question $question)
    {
        $this->authorize('update', $question);

        $tags = $question->tags()->pluck('name');

        return Inertia::render('Questions/Edit', compact('question', 'tags'));
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
        $this->authorize('update', $question);

        $question->update($request->all());

        $question->tags()->detach();

        $tagNames = explode(',', strtolower($request->input('tags')));
        foreach ($tagNames as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $question->tags()->attach($tag);
        }

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
     * @throws Exception
     */
    public function upvote(Question $question)
    {
        $this->authorize('vote', $question);

        $find = $question->votes()->where([
            'user_id' => Auth::id(),
            'votable_id' => $question->id,
            'votable_type' => Question::class,
            'vote' => 1
        ])->first();

        if ($find) {
            $find->delete();
            return redirect()->back();
        }

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
     * @throws Exception
     */
    public function downvote(Question $question)
    {
        $this->authorize('vote', $question);

        $find = $question->votes()->where([
            'user_id' => Auth::id(),
            'votable_id' => $question->id,
            'votable_type' => Question::class,
            'vote' => -1
        ])->first();

        if ($find) {
            $find->delete();
            return redirect()->back();
        }

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
