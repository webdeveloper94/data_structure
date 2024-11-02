<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function index()
    {
        $questions = Question::inRandomOrder()->take(10)->get();
        return view('test', compact('questions'));
    }

    public function store(Request $request)
    {
        $correctAnswers = 0;
        $userAnswers = [];

        foreach ($request->input('answers') as $questionId => $answer) {
            $question = Question::find($questionId);
            $userAnswers[$questionId] = $answer;

            if ($question->correct_option === $answer) {
                $correctAnswers++;
            }
        }

        $result = new Result();
        $result->user_id = Auth::id();
        $result->correct_answers = $correctAnswers;
        $result->wrong_answers = 10 - $correctAnswers; // 10 ta savol
        $result->user_answers = json_encode($userAnswers);
        $result->save();

        return redirect()->route('results', $result->id);
    }

    public function results($id)
    {
        $result = Result::find($id);
        return view('results', compact('result'));
    }
}

