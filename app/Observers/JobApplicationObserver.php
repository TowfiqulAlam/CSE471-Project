<?php
  namespace App\Observers;
  use App\Models\JobApplication;
  use Barryvdh\DomPDF\Facade\Pdf;
  use Illuminate\Support\Facades\Storage;

  class JobApplicationObserver
  {
      public function updated(JobApplication $application)
      {
          if ($application->status === 'completed') {
              $user = $application->jobSeeker;
              $jobs = JobApplication::where('job_seeker_id', $user->id)
                  ->where('status', 'completed')
                  ->with('job.employer', 'feedback')
                  ->get()
                  ->map(function($app) {
                      return [
                          'title' => $app->job->title,
                          'completed_at' => $app->updated_at,
                          'employer_name' => $app->job->employer->name,
                          'rating' => $app->feedback->rating ?? 'N/A',
                          'comment' => $app->feedback->comment ?? '',
                      ];
                  });
              $pdf = Pdf::loadView('pdf.work_portfolio', ['user'=>$user, 'jobs'=>$jobs]);
              Storage::put("portfolios/portfolio_{$user->id}.pdf", $pdf->output());
          }
     }
  }