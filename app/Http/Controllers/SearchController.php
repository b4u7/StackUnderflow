<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Question;

class SearchController extends Controller
{
    // TODO: Inertia response
    public function index(Request $request): View|Factory
    {
        $questions = Question::search($request->input('search'));

        if (Auth::hasUser() && Auth::user()->admin) {
            $questions->withTrashed();
        }

        $questions = $questions->get();

        return view('search', compact('questions'));
    }
}
