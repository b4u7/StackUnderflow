<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return RedirectResponse|View
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('questions.index');
        }

        return view('index');
    }
}
