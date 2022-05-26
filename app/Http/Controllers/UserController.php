<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $users = $request->has('query') ? User::search($request->query('query')) : User::query();

        $users = $users->orderBy('created_at', 'desc')
            ->orderBy('id')
            ->paginate(24);

        return Inertia::render('Users/Index', ['users' => $users]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): Response
    {
        $questions = $user->questions()
            ->withSum('votes', 'vote')
            ->orderByDesc('votes_sum_vote')
            ->cursorPaginate(8, cursorName: 'questions_cursor');

        $answers = $user->answers()
            ->with('question')
            ->withSum('votes', 'vote')
            ->orderByDesc('votes_sum_vote')
            ->cursorPaginate(8, cursorName: 'answers_cursor');

        $canEdit = (bool)Auth::user()?->can('update', $user);

        return Inertia::render('Users/Show', ['user' => $user, 'questions' => $questions, 'answers' => $answers, 'canEdit' => $canEdit]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, User $user): Response
    {
        $status = $request->session()->get('status');

        return Inertia::render('Users/Edit', ['user' => $user, 'status' => $status]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        return back();
    }
}
