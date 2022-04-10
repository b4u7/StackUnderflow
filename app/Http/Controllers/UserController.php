<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $users = User::query()
            ->orderByDesc('created_at')
            ->orderBy('id')
            ->cursorPaginate(24);

        return Inertia::render('User/Index', compact('users'));
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

        return Inertia::render('User/Show', compact('user', 'questions', 'answers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): Application|Factory|View
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        // update

        return back();
    }
}
