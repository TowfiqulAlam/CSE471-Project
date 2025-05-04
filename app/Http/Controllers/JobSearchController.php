<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class JobSearchController extends Controller
{
    // Show search form and job results
    public function index(Request $request)
    {
        $query = Job::query()->where('status', 'open'); // Only open jobs

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $jobs = $query->get();

        return view('jobs.search', compact('jobs'));
    }

    // Apply for a job
    public function apply($jobId)
    {
        $jobSeekerId = Auth::id();

        Application::create([
            'job_id' => $jobId,
            'job_seeker_id' => $jobSeekerId,
            'status' => 'applied',
        ]);

        return redirect()->back()->with('success', 'Applied successfully!');
    }
}
