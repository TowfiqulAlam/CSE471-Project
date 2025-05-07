<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Job;

class ChatController extends Controller
{
    public function index($job_id, $user_id)
    {
        // Fetch the messages between the sender (current user) and receiver (user_id)
        $messages = Message::where('job_id', $job_id)
            ->where(function ($query) use ($user_id) {
                $query->where('sender_id', auth()->id())
                      ->orWhere('receiver_id', auth()->id());
            })
            ->with('sender') // Eager load sender
            ->orderBy('created_at')
            ->get();

        // Fetch receiver details
        $receiver = User::findOrFail($user_id);
        
        // Fetch the job and employer details from the job
        $job = Job::findOrFail($job_id);
        $employer = User::findOrFail($job->user_id); // Employer is the user who created the job

        // Pass the required data to the view
        return view('chat.index', [
            'messages' => $messages,
            'jobId' => $job_id,
            'userId' => $user_id,
            'receiver' => $receiver,
            'job' => $job,
            'employer' => $employer, // Pass the employer to the view
        ]);
    }

    public function showChat($jobId, $userId)
    {
        // Fetch job and validate hire status
        $job = Job::findOrFail($jobId);

        // Validate if the job seeker is hired
        $isHired = Application::where('job_id', $jobId)
                    ->where('job_seeker_id', $userId)
                    ->where('status', 'hired')
                    ->exists();

        if (!$isHired) {
            abort(403, 'Chat not allowed unless the job seeker is hired.');
        }

        // Fetch the messages between the employer/job seeker for this job
        $messages = Message::where('job_id', $jobId)
                    ->where(function ($q) use ($userId) {
                        $q->where('sender_id', auth()->id())
                          ->orWhere('receiver_id', auth()->id());
                    })
                    ->orderBy('created_at')
                    ->get();

        // Fetch the employer from the job
        $employer = User::findOrFail($job->user_id);

        // Pass data to the view
        return view('chat.index', compact('messages', 'jobId', 'userId', 'employer')); // Pass employer info to the view
    }

    public function send(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        // Save the message
        Message::create([
            'job_id' => $request->job_id,
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Message sent!');
    }
}
