<?php

namespace App\Providers;

use App\Models\JobApplication;
use App\Observers\JobApplicationObserver;

class  JobApplicaton extends jobApplicationObserver

{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
         // existing boot logic
        // Register JobApplication observer for PDF generation
        \App\Models\JobApplication::observe(\App\Observers\JobApplicationObserver::class);
    }

 }


 