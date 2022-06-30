<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(): RedirectResponse|Response
    {
        if (Auth::check()) {
            return redirect()->route('questions.index');
        }

        return Inertia::render('Index', []);
    }
}
