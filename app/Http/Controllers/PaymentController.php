<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use App\Models\Endorsement;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Notifications\PaymentCompletedNotification;


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
    
    public function createStripeSession(Request $request, Task $task)
    {
        // Save selected endorsement in session temporarily
        session([
            'endorsement_tag' => $request->input('endorsement_tag'),
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Payment for ' . $task->job->title,
                    ],
                    'unit_amount' => $task->payment_amount * 100, // Stripe uses cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('employer.payment.success', $task->id),
            'cancel_url' => route('employer.payment.cancel'),
        ]);

        return redirect($session->url);
    }

    public function handleSuccess(Request $request, Task $task)
    {
        // Update task as paid
        $task->payment_status = 'paid';
        $task->save();

        // Save endorsement from session
        Endorsement::create([
            'task_id' => $task->id,
            'tag' => session('endorsement_tag'),
        ]);

        // Clear session endorsement
        session()->forget('endorsement_tag');

        // Notify the job seeker
        $task->seeker->notify(new PaymentCompletedNotification($task));

        return redirect()->route('employer.payments')->with('success', 'Payment completed and endorsement saved.');
    }

    public function handleCancel()
    {
        return redirect()->route('employer.payments')->with('error', 'Payment was cancelled.');
    }
    
    
}
