<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use Illuminate\Http\Response;

class TopicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        $topics = Topic::withCount('lessons')
            ->orderBy('order')
            ->paginate(10);
        
        return view('admin.topics', compact('topics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user() || auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized access.'], 403);
        }

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:topics,name',
                'description' => 'required|string'
            ]);

            $maxOrder = Topic::max('order') ?? 0;

            $topic = Topic::create([
                'name' => strip_tags($validated['name']),
                'description' => strip_tags($validated['description']),
                'order' => $maxOrder + 1,
                'status' => 'active'
            ]);

            return response()->json([
                'message' => 'Topic created successfully!',
                'topic' => $topic
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error creating topic: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Topic $topic)
    {
        $lessons = $topic->lessons()->orderBy('order')->get();
        return view('topic', compact('topic', 'lessons'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Topic $topic)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        return view('admin.topics.edit', compact('topic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Topic $topic)
    {
        if (!auth()->user() || auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized access.'], 403);
        }

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:topics,name,' . $topic->id,
                'description' => 'required|string'
            ]);

            $topic->update([
                'name' => strip_tags($validated['name']),
                'description' => strip_tags($validated['description'])
            ]);

            return response()->json([
                'message' => 'Topic updated successfully!',
                'topic' => $topic
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error updating topic: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $topic)
    {
        if (!auth()->user() || auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized access.'], 403);
        }

        try {
            $topic->delete();
            return response()->json(['message' => 'Topic deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error deleting topic: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showtopic($id){
        
    }
}
