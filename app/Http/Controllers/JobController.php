<?php

namespace App\Http\Controllers;


use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Application;








class JobController extends Controller
{
    // Show the job posting form
    public function create()
    {
        return view('jobs.create'); // Returns the form view
    }


    // Store the posted job
    public function store(Request $request)
    {
        // Validate the input data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric',
            'status' => 'required|in:open,closed',
            'starting_time' => 'nullable|date_format:H:i',
            'ending_time' => 'nullable|date_format:H:i',
        ]);


        // Store the job data in the database
        Job::create([
            'user_id' => Auth::id(), // Logged-in employer
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'salary' => $request->salary,
            'status' => $request->status,
            'starting_time' => $request->starting_time,
            'ending_time' => $request->ending_time,
        ]);
   


        //return redirect()->route('/dashboard')->with('success', '');
        return redirect('/dashboard')->with('success', 'Job posted successfully.');
    }




    public function apply($jobId)
    {
        // Get the authenticated user (Job Seeker)
        $user = Auth::user();


        // Check if the user is a Job Seeker
        if ($user->user_type !== 'job_seeker') {
            return redirect()->route('jobs.index')->with('error', 'You must be a job seeker to apply.');
        }


        // Find the job by ID
        $job = Job::findOrFail($jobId);


        // Create a new application entry
        Application::create([
            'job_id' => $job->id,
            'job_seeker_id' => $user->id, // ✅ your migration column
            'status' => 'applied', // Default status
        ]);
   
        return redirect()->back()->with('success', 'You have successfully applied for the job.');
    }




    // In JobController.php


    public function viewApplicants(Request $request)
    {
        $employerId = Auth::id();
   
        // Get all jobs posted by this employer
        $jobs = Job::where('user_id', $employerId)->get();
   
        // Get selected job ID from query string, or default to first
        $selectedJobId = $request->input('job_id', $jobs->first()?->id);
   
        if (!$selectedJobId) {
            return view('jobs.applicants', [
                'jobs' => $jobs,
                'selectedJob' => null,
                'applications' => collect(),
            ]);
        }
   
        // Ensure the job belongs to the logged-in employer
        $selectedJob = Job::where('id', $selectedJobId)
                          ->where('user_id', $employerId)
                          ->firstOrFail();
   
        $applications = Application::where('job_id', $selectedJobId)
            ->with('user')
            ->get();
   
        return view('jobs.applicants', [
            'jobs' => $jobs,
            'selectedJob' => $selectedJob,
            'applications' => $applications,
        ]);
    }
   


    // In JobController.php


    public function hireApplicant($applicationId)
{
    $application = \App\Models\Application::findOrFail($applicationId);


    // Confirm the employer owns the job
    if ($application->job->user_id !== Auth::id()) {
        return redirect()->back()->with('error', 'Unauthorized action.');
    }


    // Update the application status to 'hired'
    $application->status = 'hired';
    $application->save();


    // Check if task already exists (prevent duplicates)
    $existingTask = \App\Models\Task::where('job_id', $application->job_id)
                                    ->where('job_seeker_id', $application->job_seeker_id)
                                    ->first();


    if (!$existingTask) {
        // Create a task and set salary from job
        \App\Models\Task::create([
            'job_id' => $application->job_id,
            'job_seeker_id' => $application->job_seeker_id,
            'name' => 'Task for Job #' . $application->job_id,
            'status' => 'in_progress',
            'approved' => false,
            'payment_amount' => $application->job->salary,
            'payment_status' => 'unpaid',
        ]);
    }


    // Update the job status to 'closed'
    $application->job->status = 'closed';
    $application->job->save();


    // Notify the applicant (job seeker)
    $application->user->notify(new \App\Notifications\HiredForJobNotification($application->job));


    return redirect()->back()->with('success', 'Applicant hired, job closed, and task assigned.');
}




    public function fireApplicant($applicationId)
    {
        $application = \App\Models\Application::findOrFail($applicationId);


        // Ensure only the job owner can fire the applicant
        if ($application->job->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }


        $application->status = 'fired';
        $application->save();


        // Cancel task if it exists
        $task = \App\Models\Task::where('job_id', $application->job_id)
                                ->where('job_seeker_id', $application->job_seeker_id)
                                ->first();
       

        // Notify job seeker
        $application->user->notify(new \App\Notifications\FiredFromJobNotification($application->job));


        return redirect()->back()->with('success', 'Applicant has been fired.');
    }






    public function job()
    {
        return $this->belongsTo(Job::class);
    }
   
   
}
