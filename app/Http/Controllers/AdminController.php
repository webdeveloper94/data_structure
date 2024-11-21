<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Topic;
use App\Models\Lesson;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        try {
            $totalUsers = User::count();
            $totalTopics = Topic::count();
            $activeLessons = Lesson::count();
            $completedTests = Test::count();
            $topics = Topic::all();
            
            // Get recent activities
            $recentLessons = Lesson::latest()->take(3)->get()
                ->map(function($lesson) {
                    return [
                        'description' => "New lesson added: {$lesson->title}",
                        'created_at' => $lesson->created_at,
                        'type' => 'lesson'
                    ];
                });
            
            $recentTests = Test::latest()->take(3)->get()
                ->map(function($test) {
                    return [
                        'description' => "New test created: {$test->title}",
                        'created_at' => $test->created_at,
                        'type' => 'test'
                    ];
                });
            
            $recentActivities = $recentLessons->concat($recentTests)
                ->sortByDesc('created_at')
                ->take(5);

            return view('admin.admin', compact(
                'totalUsers',
                'totalTopics',
                'activeLessons',
                'completedTests',
                'topics',
                'recentActivities'
            ));
        } catch (\Exception $e) {
            Log::error('Error in AdminController index method: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return view('admin.admin')->with('error', 'Error loading dashboard data');
        }
    }

    /**
     * Store a new test.
     */
    public function storeTest(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'time_limit' => 'required|integer|min:1',
            'passing_score' => 'required|integer|between:0,100',
            'difficulty' => 'required|in:beginner,intermediate,advanced',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.options' => 'required|array|size:3',
            'questions.*.options.*' => 'required|string',
            'questions.*.correct_answer' => 'required|integer|between:0,2',
            'questions.*.points' => 'required|integer|min:1',
            'questions.*.explanation' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $test = Test::create([
                'topic_id' => $request->topic_id,
                'title' => $request->title,
                'description' => $request->description,
                'time_limit' => $request->time_limit,
                'passing_score' => $request->passing_score,
                'difficulty' => $request->difficulty,
                'status' => 'draft',
            ]);

            foreach ($request->questions as $index => $questionData) {
                $test->questions()->create([
                    'question' => $questionData['question'],
                    'options' => $questionData['options'],
                    'correct_answer' => $questionData['options'][$questionData['correct_answer']],
                    'points' => $questionData['points'],
                    'explanation' => $questionData['explanation'] ?? null,
                    'order' => $index + 1,
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Test created successfully',
                'test' => $test->load('questions'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating test: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Error creating test: ' . $e->getMessage(),
            ], 500);
        }
    }
}
