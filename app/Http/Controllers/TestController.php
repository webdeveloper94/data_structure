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
        try {
            DB::beginTransaction();
            
            // Create the test
            $test = Test::create([
                'topic_id' => $request->topic_id,
                'title' => $request->title,
                'description' => $request->description,
                'time_limit' => $request->time_limit,
                'passing_score' => $request->passing_score,
                'status' => 'draft',
            ]);

            // Create questions for this test
            foreach ($request->questions as $questionData) {
                Question::create([
                    'test_id' => $test->id,
                    'question' => $questionData['text'],
                    'options' => $questionData['options'],
                    'correct_answer' => $questionData['correct_option'],
                    'points' => 1, // Default points
                    'order' => 1 // Default order
                ]);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Test created successfully!']);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Error creating test: ' . $e->getMessage()]);
        }
    }

    public function results($id)
    {
        $result = Result::find($id);
        return view('results', compact('result'));
    }
}
