<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch user's skills
        $userSkills = DB::table('skills')
            ->where('user_id', $user->id)
            ->pluck('name');

        // Fetch videos matching user's skills
        $videos = DB::table('videos')
            ->whereIn('skill_name', $userSkills)
            ->get();

        return view('Videos.index', compact('videos'));
    }


    public function uploadForm()
    {
        return view('videos.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'skill_name' => 'required|string',
            'video_file' => 'required|mimes:mp4|max:50000', // max ~50MB
        ]);

        // Store video in 'storage/app/public/videos'
        $path = $request->file('video_file')->store('videos', 'public');

        DB::table('videos')->insert([
            'title' => $request->title,
            'description' => $request->description,
            'skill_name' => $request->skill_name,
            'url' => 'storage/' . $path, // Save public path
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/videos')->with('success', 'Video uploaded successfully.');
    }

}
