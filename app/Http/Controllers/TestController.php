<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Result;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
        $questions = Question::inRandomOrder()->take(10)->get();
        return view('test', compact('questions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'time_limit' => 'required|integer|min:1',
            'passing_score' => 'required|integer|between:0,100',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.options' => 'required|array',
            'questions.*.options.*' => 'required|string',
            'questions.*.correct_option' => 'required|in:a,b,c',
            'answers' => 'required|array',
            'answers.*' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            // Create the test
            $test = Test::create([
                'topic_id' => $request->topic_id,
                'title' => $request->title,
                'description' => $request->description,
                'time_limit' => $request->time_limit,
                'passing_score' => $request->passing_score,
                'status' => 'active'
            ]);

            // Create questions
            foreach ($request->questions as $questionData) {
                $question = Question::create([
                    'test_id' => $test->id,
                    'question' => $questionData['text'],
                    'option_a' => $questionData['options']['a'],
                    'option_b' => $questionData['options']['b'],
                    'option_c' => $questionData['options']['c'],
                    'correct_option' => $questionData['correct_option']
                ]);
            }

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

            DB::commit();
            return redirect()->route('results', $result->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error creating test: ' . $e->getMessage()], 500);
        }
    }

    public function results($id)
    {
        $result = Result::find($id);
        return view('results', compact('result'));
    }
}
