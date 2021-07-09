<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return RedirectResponse | \Inertia\Response
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('questions.index');
        }

        return Inertia::render('Index', []);
    }
}
