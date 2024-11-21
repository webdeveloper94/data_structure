<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lessons = Lesson::all();

        return view('welcome');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $topics = Topic::all();
        return view('admin.lessons.create', compact('topics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'topic_id' => 'required|exists:topics,id',
            'description' => 'required|string',
            'content' => 'required|string',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced',
            'estimated_time' => 'required|integer|min:1',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
        ]);

        try {
            $lesson = new Lesson();
            $lesson->title = $request->title;
            $lesson->topic_id = $request->topic_id;
            $lesson->description = $request->description;
            $lesson->content = $request->content;
            $lesson->difficulty_level = $request->difficulty_level;
            $lesson->estimated_time = $request->estimated_time;
            
            // Handle file upload if attachment is present
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('lesson_attachments', $filename, 'public');
                $lesson->attachment = $path;
            }
            
            $lesson->save();

            return redirect()->back()->with('success', 'Lesson created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating lesson: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($lesson)
    {
        if (!Auth::check()) {
            return redirect()->route('login'); // Login sahifasi
        }
        $lessons = Lesson::where('title', $lesson)->first();
        $lesson_id = $lessons->id;
        $topics = Topic::where('lesson_id', $lesson_id)->get();
        return view('lesson', compact('topics'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
