<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class JobSeekerController extends Controller
{
    public function show($id)
    {
        $user = User::with(['skills', 'availability', 'ratings.rater', 'portfolio'])->findOrFail($id);

        return view('jobseekers.profile', compact('user'));
    }
    public function viewRatings($id)
    {
        $user = User::find($id);
        $ratings = $user->ratings; // Assuming you have a ratings relationship
        return view('jobseekers.ratings', compact('user', 'ratings'));
    }

    public function viewPortfolio($id)
    {
        $user = User::find($id);
        $portfolio = $user->portfolio; // Assuming you have a portfolio relationship
        return view('jobseekers.portfolio', compact('user', 'portfolio'));
    }

    public function viewSkills($id)
    {
        $user = User::find($id);
        $skills = $user->skills; // Assuming you have a skills relationship
        return view('jobseekers.skills', compact('user', 'skills'));
    }

    public function viewAvailability($id)
    {
        $user = User::find($id);
        $availability = $user->availability; // Assuming you have an availability relationship
        return view('jobseekers.availability', compact('user', 'availability'));
    }

    public function hiredEmployees()
    {
        $jobs = Job::with(['applications' => function ($query) {
            $query->where('status', 'hired')->with('jobSeeker');
        }])->where('user_id', Auth::id())->get();

        return view('employer.hired_employees', compact('jobs'));
    }

}
