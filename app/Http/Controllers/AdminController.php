<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Topic;
use App\Models\Lesson;
use App\Models\Test;
use App\Models\Question;
use App\Models\Result;
use App\Models\Lab;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
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

    public function users()
    {
        $users = User::paginate(10);
        return view('admin.users', compact('users'));
    }

    public function updateRole(User $user, Request $request)
    {
        $request->validate([
            'role' => 'required|in:user,admin'
        ]);

        $user->update([
            'role' => $request->role
        ]);

        return redirect()->back()->with('status', 'User role updated successfully!');
    }

    public function blockUser(User $user, Request $request)
    {
        $request->validate([
            'blocked_until' => 'required|date|after:now',
            'block_reason' => 'required|string|max:1000'
        ]);

        $user->update([
            'status' => 'blocked',
            'blocked_until' => $request->blocked_until,
            'block_reason' => $request->block_reason
        ]);

        return redirect()->back()->with('status', 'User blocked successfully!');
    }

    public function unblockUser(User $user)
    {
        $user->update([
            'status' => 'active',
            'blocked_until' => null,
            'block_reason' => null
        ]);

        return redirect()->back()->with('status', 'User unblocked successfully!');
    }

    public function banUser(User $user, Request $request)
    {
        $request->validate([
            'block_reason' => 'required|string|max:1000'
        ]);

        $user->update([
            'status' => 'banned',
            'blocked_until' => null,
            'block_reason' => $request->block_reason
        ]);

        return redirect()->back()->with('status', 'User banned successfully!');
    }

    public function unbanUser(User $user)
    {
        $user->update([
            'status' => 'active',
            'blocked_until' => null,
            'block_reason' => null
        ]);

        return redirect()->back()->with('status', 'User unbanned successfully!');
    }

    public function tests()
    {
        $tests = Test::with(['topic'])
            ->withCount('questions')
            ->latest()
            ->paginate(10);
        
        $topics = Topic::all();
        
        return view('admin.tests', compact('tests', 'topics'));
    }

    public function editTest(Test $test)
    {
        return response()->json($test);
    }

    public function updateTest(Request $request, Test $test)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'topic_id' => 'required|exists:topics,id',
            'description' => 'nullable|string',
            'time_limit' => 'required|integer|min:1',
            'status' => 'required|in:draft,active,archived'
        ]);

        $test->update($request->all());

        return redirect()->back()->with('success', 'Test updated successfully');
    }

    public function deleteTest(Test $test)
    {
        $test->delete();
        return redirect()->back()->with('success', 'Test deleted successfully');
    }

    public function testResults(Test $test)
    {
        $results = Result::with('user')
            ->where('test_id', $test->id)
            ->latest()
            ->get()
            ->map(function ($result) {
                return [
                    'user' => [
                        'name' => $result->user->name,
                        'email' => $result->user->email
                    ],
                    'score' => $result->score,
                    'time_taken' => $result->time_taken,
                    'status' => $result->status,
                    'completed_at' => $result->completed_at
                ];
            });

        return response()->json($results);
    }

    public function storeTest(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'topic_id' => 'required|exists:topics,id',
            'description' => 'nullable|string',
            'time_limit' => 'required|integer|min:1',
            'status' => 'required|in:draft,active,archived'
        ]);

        $test = Test::create($validated);

        return redirect()->route('admin.tests.index')
            ->with('success', 'Test created successfully.');
    }

    public function labs(Lesson $lesson)
    {
        $topics = Topic::all();
        $labs = $lesson->labs()->with(['topic'])->paginate(10);
        return view('admin.labs', compact('lesson', 'labs', 'topics'));
    }

    public function storeLab(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'topic_id' => 'required|exists:topics,id',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url|max:255',
            'animation_url' => 'nullable|url|max:255',
            'status' => 'required|in:draft,published,archived'
        ]);

        $lab = $lesson->labs()->create($validated);

        return redirect()->route('admin.labs.index', $lesson)
            ->with('success', 'Lab created successfully.');
    }

    public function editLab(Lesson $lesson, Lab $lab)
    {
        return response()->json($lab);
    }

    public function updateLab(Request $request, Lesson $lesson, Lab $lab)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'topic_id' => 'required|exists:topics,id',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url|max:255',
            'animation_url' => 'nullable|url|max:255',
            'status' => 'required|in:draft,published,archived'
        ]);

        $lab->update($validated);

        return redirect()->route('admin.labs.index', $lesson)
            ->with('success', 'Lab updated successfully.');
    }

    public function deleteLab(Lesson $lesson, Lab $lab)
    {
        $lab->delete();
        return redirect()->route('admin.labs.index', $lesson)
            ->with('success', 'Lab deleted successfully.');
    }
}
