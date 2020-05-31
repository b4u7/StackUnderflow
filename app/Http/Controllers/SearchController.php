<?php

namespace App\Http\Controllers;

use Auth;
use App\Question;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $questions = Question::search($request->input('search'));

        if (Auth::hasUser() && Auth::user()->admin) {
            $questions->withTrashed();
        }

        $questions = $questions->get();

        return view('search', compact('questions'));
    }
}
