<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Skill;
use App\Models\Availability;
use App\Models\Portfolio;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;
use App\Models\JobApplication;



class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'date_of_birth' => 'required|date',
            'occupation' => 'required|string',
        ]);

        $user->update($request->only('name', 'email', 'date_of_birth', 'occupation'));

        return redirect('/dashboard')->with('success', 'Profile updated successfully.');
    }


    public function viewApplicant(User $user)
    {
        $skills = DB::table('skills')->where('user_id', $user->id)->get();
        $availability = DB::table('availability')->where('user_id', $user->id)->first();
        $portfolio = DB::table('portfolios')->where('user_id', $user->id)->first();
        $ratings = $user->ratings()->latest()->get();

        $jobApplications = JobApplication::where('job_seeker_id', $user->id)->get();


        return view('applicants.view', compact('user', 'skills', 'availability', 'portfolio', 'ratings', 'jobApplications'));


    }
}
