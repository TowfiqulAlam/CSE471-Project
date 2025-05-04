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

        return view('videos.index', compact('videos'));
    }
}
