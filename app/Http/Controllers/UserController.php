<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
    public function index(): Response
    {
        $users = User::query()
            ->orderByDesc('created_at')
            ->orderBy('id')
            ->cursorPaginate(24);

        return Inertia::render('Users/Index', compact('users'));
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

        return Inertia::render('Users/Show', compact('user', 'questions', 'answers', 'canEdit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): Response
    {
        return Inertia::render('Users/Edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        return back();
    }
}
