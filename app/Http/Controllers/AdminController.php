<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Topic;
use App\Models\Lesson;
use App\Models\Test;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Handle the dashboard route and redirect admins.
     */
    public function dashboard(): \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    }

    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $totalUsers = User::count();
        $totalTopics = Topic::count();
        $totalLessons = Lesson::count();
        $totalTests = Test::count();
        $activeLessons = Lesson::where('status', 'published')->count();
        $completedTests = Test::where('status', 'completed')->count();

        $recentUsers = User::latest()->take(5)->get();
        $recentLessons = Lesson::with('topic')->latest()->take(5)->get();
        $recentTests = Test::latest()->take(5)->get();
        $topics = Topic::all();

        // Prepare recent activities
        $recentActivities = collect();

        // Add recent lessons to activities
        foreach ($recentLessons as $lesson) {
            $recentActivities->push([
                'type' => 'lesson',
                'description' => "New lesson added: {$lesson->title}",
                'created_at' => $lesson->created_at,
            ]);
        }

        // Add recent tests to activities
        foreach ($recentTests as $test) {
            $recentActivities->push([
                'type' => 'test',
                'description' => "New test created: {$test->title}",
                'created_at' => $test->created_at,
            ]);
        }

        // Sort activities by created_at
        $recentActivities = $recentActivities->sortByDesc('created_at')->take(10);

        return view('admin.admin', compact(
            'totalUsers',
            'totalTopics',
            'totalLessons',
            'totalTests',
            'activeLessons',
            'completedTests',
            'recentUsers',
            'recentLessons',
            'recentTests',
            'recentActivities',
            'topics'
        ));
    }

    /**
     * Store a new question.
     */
    public function storeQuestion(Request $request)
    {
        $request->validate([
            'test_id' => 'required|exists:tests,id',
            'question_text' => 'required|string',
            'options' => 'required|array|min:2',
            'correct_answer' => 'required|integer|min:0',
        ]);

        try {
            DB::beginTransaction();

            $question = Question::create([
                'test_id' => $request->test_id,
                'question_text' => $request->question_text,
                'options' => json_encode($request->options),
                'correct_answer' => $request->correct_answer,
            ]);

            DB::commit();
            return response()->json(['message' => 'Question created successfully', 'question' => $question]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating question: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create question'], 500);
        }
    }
}
