<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use App\Models\Endorsement;


class PaymentController extends Controller
{
    // Show all hired but unpaid tasks for this employer
    public function index()
    {
        $tasks = Task::whereHas('job', function ($query) {
                        $query->where('user_id', Auth::id());
                    })
                    ->whereIn('status', ['in_progress', 'completed'])
                    ->whereIn('payment_status', ['paid','unpaid'])
                    ->with(['job', 'seeker'])
                    ->get();

        return view('employer.payments', compact('tasks'));
    }

    // Handle payment action

    public function pay(Request $request, $taskId)
    {
        // Retrieve the task
        $task = Task::findOrFail($taskId);
    
        // Mark the payment as 'paid'
        $task->payment_status = 'paid';
        $task->save();
    
        // Save endorsement
        Endorsement::create([
            'task_id' => $task->id,
            'tag' => $request->input('endorsement_tag'), // Correct use of $request
        ]);
    
        return redirect()->route('employer.payments')->with('success', 'Payment marked as completed.');
    }
    
    
}
