<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionStoreRequest;
use App\Http\Requests\QuestionUpdateRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Tag;
use App\Models\Vote;
use Auth;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;
use stdClass;
use Throwable;

class QuestionController extends Controller
{
    /**
     * QuestionController constructor.
     */
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
    {
        $this->authorize('viewAny', Question::class);

        if ($request->has('query')) {
            $questions = Question::search($request->query('query'))
                ->query(
                    fn(Builder $query) => $query
                        ->with(['votes', 'answers', 'user', 'tags'])
                );
        } else {
            $questions = Question::with(['votes', 'answers', 'user', 'tags'])
                ->orderByDesc('votes_sum_vote');
        }

        $questions = $questions
            ->when(
                Auth::user()?->admin,
                static fn(\Illuminate\Database\Eloquent\Builder|\Laravel\Scout\Builder $query) => $query->withTrashed()
            )
            ->paginate(10);

        $tags = Tag::whereHas('questions')
            ->take(10)
            ->get();

        return Inertia::render('Questions/Index', ['questions' => $questions, 'tags' => $tags]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize('create', Question::class);

        $tagsList = Tag::all();

        return Inertia::render('Questions/Create', ['tagsList' => $tagsList]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function store(QuestionStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Question::class);

        $question = DB::transaction(function () use ($request) {
            $question = $request->user()->questions()->create($request->validated());

            $tags = $request->validated('tags');
            $tagIds = [];

            foreach ($tags as $tag) {
                $tag = Tag::firstOrCreate(['name' => $tag['name']]);
                $tagIds[] = $tag->id;
            }

            $question->tags()->sync($tagIds);

            return $question;
        });

        return redirect()->route('questions.show', [$question]);
    }

    /**
     * Display the specified resource.
     *
     * @throws AuthorizationException
     */
    public function show(int $questionId): Response
    {
        $user = Auth::user();

        $question = Question::with([
            'user',
            'tags',
        ])->when($user !== null && $user->admin, fn($query) => $query->withTrashed())
            ->findOrFail($questionId);

        $this->authorize('view', $question);
        views($question)->record();

        $answers = $question->answers()
            ->with('user')
            ->when(
                $user,
                static fn(Builder $query) => $query->withSum(
                    ['votes as user_vote' => static fn(Builder $q) => $q->where('user_id', '=', $user->id)],
                    'vote'
                )
            )
            ->when($user !== null && $user->admin, fn(Builder $q) => $q->withTrashed())
            ->when(
                $question->solution_id !== null,
                static fn(Builder $q) => $q->orderByDesc(DB::raw('id = ' . $question->solution_id))
            )
            ->orderByDesc(DB::raw('votes_sum_vote'))
            ->cursorPaginate(cursorName: 'answersCursor');

        $userQuestionVote = $user === null ? null : Vote::query()
            ->where('votable_type', '=', Question::class)
            ->where('votable_id', '=', $question->id)
            ->where('user_id', '=', $user->id)
            ->first();

        $userAnswered = transform($user, fn($u) => $question->answers()->where('user_id', '=', $u->id)->exists(), false);

        $bookmarked = $user?->bookmarkedQuestions()->whereKey($question->id)->exists() ?? false;

        $permissions = [
            'question' => [
                'canCreate' => Gate::check('create', $question),
                'canAnswer' => Gate::inspect('create', [Answer::class, $question]),
                'canEdit' => Gate::check('update', $question),
                'canVote' => Gate::check('vote', $question),
                'canBookmark' => Gate::check('bookmark', $question),
                'canUnbookmark' => Gate::check('unbookmark', $question),
                'canDelete' => Gate::check('delete', $question),
                'canRestore' => Gate::check('restore', $question),
            ],
            'answers' => new stdClass()
        ];

        foreach ($answers as $answer) {
            $permissions['answers']->{$answer->id}['canEdit'] = Gate::check('update', $answer);
            $permissions['answers']->{$answer->id}['canVote'] = Gate::check('vote', $answer);
            $permissions['answers']->{$answer->id}['canMarkSolution'] = Gate::check('solution', $answer);
            $permissions['answers']->{$answer->id}['canDelete'] = Gate::check('delete', $answer);
            $permissions['answers']->{$answer->id}['canRestore'] = Gate::check('restore', $answer);
        }

        $isTrashed = $question->trashed();

        return Inertia::render('Questions/Show', ['question' => $question, 'answers' => $answers, 'isTrashed' => $isTrashed, 'bookmarked' => $bookmarked, 'userAnswered' => $userAnswered, 'userQuestionVote' => $userQuestionVote, 'permissions' => $permissions]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @throws AuthorizationException
     */
    public function edit(Question $question): Response
    {
        $this->authorize('update', $question);

        $question->load('tags');

        $tagsList = Tag::all();

        return Inertia::render('Questions/Edit', ['question' => $question, 'tagsList' => $tagsList]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function update(QuestionUpdateRequest $request, Question $question): RedirectResponse
    {
        $this->authorize('update', $question);

        DB::transaction(function () use ($request, $question) {
            $question->update($request->validated());

            $tags = $request->validated('tags');
            $tagIds = [];

            foreach ($tags as $tag) {
                $tag = Tag::firstOrCreate(['name' => $tag['name']]);
                $tagIds[] = $tag->id;
            }

            $question->tags()->sync($tagIds);
        });

        return redirect()->route('questions.show', [$question->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws Exception
     */
    public function destroy(Request $request, Question $question): RedirectResponse
    {
        $this->authorize('delete', $question);

        $question->delete();

        return $request->user()->can('view', $question) ? back() : redirect()->route('questions.index');
    }

    /**
     * Restore the specified resource from storage.
     *
     * @throws AuthorizationException
     */
    public function restore(Question $question): RedirectResponse
    {
        $this->authorize('restore', $question);

        $question->restore();

        return back();
    }

    /**
     * Upvotes the current question.
     *
     * @throws Exception
     */
    public function upvote(Question $question): RedirectResponse
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
            return back();
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

        return back();
    }

    /**
     * Downvotes the current question.
     *
     * @throws Exception
     */
    public function downvote(Question $question): RedirectResponse
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
            return back();
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

        return back();
    }
}
