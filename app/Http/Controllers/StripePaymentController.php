<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Endorsement;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Facades\URL;

class StripePaymentController extends Controller
{
    public function stripePay(Request $request, $taskId)
    {
        $task = Task::with(['job', 'seeker'])->findOrFail($taskId);

        // Save endorsement in session temporarily
        session([
            'endorsement_tag' => $request->endorsement_tag,
            'task_id' => $taskId
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $task->job->title . ' - Payment for ' . $task->seeker->name,
                    ],
                    'unit_amount' => $task->payment_amount * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('employer.stripe.success'),
            'cancel_url' => route('employer.stripe.cancel'),
        ]);

        return redirect($session->url);
    }

    public function success()
    {
        $taskId = session('task_id');
        $tag = session('endorsement_tag');

        $task = Task::findOrFail($taskId);
        $task->payment_status = 'paid';
        $task->save();

        Endorsement::create([
            'task_id' => $taskId,
            'tag' => $tag,
        ]);

        // Clear session
        session()->forget(['task_id', 'endorsement_tag']);

        return redirect()->route('employer.payments')->with('success', 'Payment completed and endorsement saved.');
    }

    public function cancel()
    {
        return redirect()->route('employer.payments')->with('error', 'Payment was cancelled.');
    }
}
