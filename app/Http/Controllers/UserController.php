<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $users = User::query()
            ->orderByDesc('created_at')
            ->orderBy('id')
            ->cursorPaginate(24);

        return Inertia::render('User/Index', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Inertia\Response
     */
    public function show(User $user)
    {
        // $votes = User::where('')

        return Inertia::render('User/Show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        // update

        return back();
    }
}
