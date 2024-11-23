<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        $lessons = Lesson::with('topic')
            ->orderBy('order')
            ->paginate(10);
        $topics = Topic::all();

        return view('admin.lessons', compact('lessons', 'topics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() 
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        $topics = Topic::all();
        return view('admin.lessons.create', compact('topics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user() || auth()->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Unauthorized access.',
                'errors' => ['auth' => ['You are not authorized to perform this action.']]
            ], 403);
        }

        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'topic_id' => 'required|exists:topics,id',
                'content' => 'required|string',
                'order' => 'required|integer|min:1',
                'status' => 'required|in:draft,published,archived'
            ], [
                'title.required' => 'The lesson title is required.',
                'topic_id.required' => 'Please select a topic.',
                'topic_id.exists' => 'The selected topic is invalid.',
                'content.required' => 'The lesson content is required.',
                'order.required' => 'The lesson order is required.',
                'order.integer' => 'The order must be a number.',
                'order.min' => 'The order must be at least 1.',
                'status.required' => 'Please select a status.',
                'status.in' => 'The selected status is invalid.'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Please fill in all required fields correctly.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();

            // Add description field
            $validated['description'] = $request->input('description', '');

            $lesson = Lesson::create([
                'title' => strip_tags($validated['title']),
                'topic_id' => $validated['topic_id'],
                'description' => $validated['description'],
                'content' => $validated['content'],
                'order' => $validated['order'],
                'status' => $validated['status']
            ]);

            return response()->json([
                'message' => 'Lesson created successfully!',
                'lesson' => $lesson
            ]);

        } catch (\Exception $e) {
            Log::error('Error creating lesson: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while creating the lesson.',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $topics = Topic::where('lesson_id', $lesson->id)->get();
        return view('lesson', compact('lesson', 'topics'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        $topics = Topic::all();
        return view('admin.lessons.edit', compact('lesson', 'topics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lesson $lesson)
    {
        if (!auth()->user() || auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized access.'], 403);
        }

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'topic_id' => 'required|exists:topics,id',
                'content' => 'required|string',
                'order' => 'required|integer|min:1',
                'status' => 'required|in:draft,published,archived'
            ]);

            $lesson->update([
                'title' => strip_tags($validated['title']),
                'topic_id' => $validated['topic_id'],
                'content' => $validated['content'],
                'order' => $validated['order'],
                'status' => $validated['status']
            ]);

            return response()->json([
                'message' => 'Lesson updated successfully!',
                'lesson' => $lesson
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error updating lesson: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        try {
            $lesson->delete();
            return redirect()->route('admin.lessons.index')
                ->with('status', 'Lesson deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting lesson: ' . $e->getMessage());
        }
    }
}
