<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // if (auth()->user()->is_admin) {
            return view('pages.dashboard');
        // } else {
        //     return redirect()->route('exam', []);
        // }

    }

    public function questionindex()
    {
        return view('question.index');
    }
}
