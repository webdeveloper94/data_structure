<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Topic;

use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($topic)
    {
         $topicm = Topic::where('id', $topic)->first();
         $lessons = Lesson::where('id', $topicm->lesson_id)->first();
         $topics = Topic::where('lesson_id', $lessons->id)->get();
         return view('topic', compact('topicm', 'topics'));
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


    public function showtopic($id){
        
    }
}
