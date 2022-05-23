<?php

namespace App\Http\Controllers\Questions;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Question $question): RedirectResponse
    {
        $this->authorize('bookmark', $question);

        $request->user()->bookmarkedQuestions()->attach($question);

        return back();
    }
}
