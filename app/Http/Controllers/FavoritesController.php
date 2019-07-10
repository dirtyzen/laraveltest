<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;

class FavoritesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Question $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Question $question)
    {
        $question->favorites()->attach(auth()->id());
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Question $question)
    {
        $question->favorites()->detach(auth()->id());
        return back();
    }


}
