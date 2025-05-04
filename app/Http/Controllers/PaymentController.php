<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

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
    public function pay($taskId)
    {
        $task = Task::where('id', $taskId)
                    ->whereHas('job', function ($query) {
                        $query->where('user_id', Auth::id());
                    })
                    ->firstOrFail();

        $task->payment_status = 'paid';
        $task->save();

        return redirect()->route('employer.payments')->with('success', 'Payment marked as completed.');
    }
}
