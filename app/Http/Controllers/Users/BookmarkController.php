<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class BookmarkController extends Controller
{
    public function __invoke(User $user): Response
    {
        $bookmarkedQuestions = $user
            ->bookmarkedQuestions()
            ->with('user', 'answers', 'tags')
            ->cursorPaginate(8);

        return Inertia::render('Users/Bookmarks/Index', compact('bookmarkedQuestions'));
    }
}
