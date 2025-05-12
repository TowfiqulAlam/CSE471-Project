<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;


class ApplicationController extends Controller
{
    // Other methods...


    /**
     * Toggle the application status between 'applied', 'hired', 'rejected' and 'completed'
     *
     * @param  int  $applicationId
     * @param  string  $status
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $applicationId)
    {
        // Find the application by ID
        $application = Application::findOrFail($applicationId);


        // Check if the status exists in the allowed statuses
        $allowedStatuses = ['applied', 'hired', 'rejected', 'completed'];
        if (!in_array($request->status, $allowedStatuses)) {
            return redirect()->back()->with('error', 'Invalid status update.');
        }


        // Update the application status
        $application->status = $request->status;


        // Save the updated status
        $application->save();


        // Return the user back with a success message
        return redirect()->back()->with('success', 'Applicant status updated!');
    }
}
