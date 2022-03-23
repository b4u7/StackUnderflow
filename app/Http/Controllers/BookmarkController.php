<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bookmark;
use App\Models\Question;

class BookmarkController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @throws AuthorizationException
     */
    public function store(Request $request, Question $question): RedirectResponse
    {
        $this->authorize('create', [Bookmark::class, $question]);

        $question->bookmarks()->updateOrCreate([
            'user_id' => Auth::id()
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws AuthorizationException
     */
    public function destroy(Question $question, int $bookmarkId): RedirectResponse
    {
        $bookmark = $question->bookmarks()->findOrFail($bookmarkId);

        $this->authorize('delete', $bookmark);

        $bookmark->delete();

        return back();
    }
}
