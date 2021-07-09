<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bookmark;
use App\Models\Question;

class BookmarkController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Question $question)
    {
        $this->authorize('create', [Bookmark::class, $question]);

        $question->bookmarks()->updateOrCreate([
            'user_id' => Auth::id()
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Question $question
     * @param \App\Models\Bookmark $bookmark
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Question $question, int $bookmarkId)
    {
        $bookmark = $question->bookmarks()->findOrFail($bookmarkId);

        $this->authorize('delete', $bookmark);

        $bookmark->delete();

        return redirect()->back();
    }
}
