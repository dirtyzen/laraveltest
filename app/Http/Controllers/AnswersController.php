<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index(Question $question)
    {
        return $question->answers()->with('user')->simplePaginate(3);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Question $question
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Question $question ,Request $request)
    {

        $answer = $question->answers()->create(
            $request->validate(['body' => 'required']) + ['user_id' => Auth::id()]
        );

        if(request()->expectsJson()){
            return response()->json([
                'message' => 'Your answer has been submitted successfully.',
                'answer' => $answer->load('user')
            ]);
        }

        return back()->with('success', 'Your answer has been submitted successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Question $question
     * @param Answer $answer
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Question $question, Answer $answer)
    {

        $this->authorize('update', $answer);

        return view('answers.edit', compact('question', 'answer'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Question $question
     * @param Answer $answer
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Question $question, Answer $answer)
    {

        $this->authorize('update', $answer);

        $answer->update($request->validate([
            'body' => 'required'
        ]));

        //for vue/axios
        if($request->expectsJson()){
            return response()->json([
                'message' => 'Your answer has been updated successfully.',
                'body_html' => $answer->body_html
            ]);
        }

        return redirect()->route('questions.show', $question->slug)->with('success', 'Your answer has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @param Answer $answer
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Question $question, Answer $answer)
    {

        $this->authorize('delete', $answer);

        $answer->delete();

        if(request()->expectsJson()){
            return response()->json([
                'message' => 'Your answers has been deleted successfully.'
            ]);
        }

        return back()->with('success', 'Your answers has been deleted successfully.');
    }
}
