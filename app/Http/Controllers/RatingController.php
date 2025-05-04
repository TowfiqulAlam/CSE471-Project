<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\Task;


class RatingController extends Controller
{
    // Show the form for creating a rating for a specific job seeker (user)
    public function create($userId)
    {
        // Fetch the user to be rated (job seeker)
        $user = User::with('jobs')->find($userId);


        return view('ratings.create', compact('user'));
    }


    // Store the submitted rating data in the database
    public function store(Request $request)
    {
        // Validate the rating form data
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000',
        ]);
   
        // Get the completed task for the given job
        $completedTask = Task::where('job_id', $request->job_id)
            ->where('status', 'completed')
            ->first();
   
        // Check if task is completed before allowing rating
        if (!$completedTask) {
            return redirect()->back()->with('error', 'Rating is allowed only after task completion.');
        }
   
        // Create the rating entry in the database
        Rating::create([
            'rater_id' => Auth::id(), // employer's ID
            'user_id' => $completedTask->job_seeker_id, // job seeker's ID from the task table
            'job_id' => $request->job_id,
            'rating' => $request->rating,
            'feedback' => $request->feedback,
        ]);
   
        // Redirect back to the rating creation page with userId
        return redirect()->route('ratings.create', ['userId' => $completedTask->job_seeker_id])
                         ->with('success', 'Rating submitted successfully.');
    }
}
