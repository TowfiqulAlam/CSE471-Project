<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Show tasks assigned to the job seeker
    public function index()
    {
        $tasks = Task::where('job_seeker_id', Auth::id())->get(); // changed user_id to job_seeker_id
        return view('tasks.index', compact('tasks'));
    }

    // Update task status
    public function updateStatus(Request $request, $id)
    {
        $task = Task::where('id', $id)
                    ->where('job_seeker_id', Auth::id()) // changed user_id to job_seeker_id
                    ->firstOrFail();

        $task->status = $request->input('status');
        $task->save();

        return redirect()->back()->with('success', 'Task status updated successfully.');
    }

    public function approveTask($taskId)
    {
        $task = Task::findOrFail($taskId);

        // Check if the task is completed and not already approved
        if ($task->status == 'completed' && !$task->approved) {
            // Mark task as approved
            $task->approved = true;
            $task->payment_status = 'paid'; // Track payment status
            $task->save();

            return redirect()->route('tasks.index')->with('status', 'Task approved and payment marked as completed.');
        }

        return redirect()->route('tasks.index')->with('error', 'Only completed tasks can be approved or paid.');
    }
}
