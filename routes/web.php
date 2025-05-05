<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobSearchController;
use App\Http\Controllers\RatingController;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\JobSeekerController;
use App\Http\Controllers\EndorsementController;





Route::get('/', function () {
    return view('welcome');
});

// Dashboard

Route::get('/dashboard', function () {
    $job = Job::where('user_id', Auth::id())->latest()->first(); // 👈 Get latest job posted by the logged-in user
    return view('dashboard', compact('job')); // 👈 Pass $job to the view
})->middleware(['auth'])->name('home');


// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);


///
Route::get('/profile', [ProfileController::class, 'edit'])->middleware('auth');
Route::post('/profile', [ProfileController::class, 'update'])->middleware('auth');


//
Route::get('/skills', [SkillController::class, 'edit']);
Route::post('/skills', [SkillController::class, 'update']);

Route::get('/availability', [AvailabilityController::class, 'edit']);
Route::put('/availability', [AvailabilityController::class, 'update']);

Route::get('/portfolio', [PortfolioController::class, 'edit']);
Route::put('/portfolio', [PortfolioController::class, 'update']);


//Video suggestion
Route::get('/videos', [VideoController::class, 'index'])->middleware('auth');

// Task:
// Show tasks
Route::get('/tasks', [TaskController::class, 'index'])->middleware('auth');
// Update status
Route::post('/tasks/{id}/update-status', [TaskController::class, 'updateStatus'])->middleware('auth');
//


//Payment
Route::post('/tasks/{task}/approve', [TaskController::class, 'approvePayment'])->name('tasks.approve');


// Job Post:
// Route for displaying the job post form
Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');

// Route for handling job post submission
Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
});


Route::post('/jobs/{jobId}/apply', [JobController::class, 'apply'])->name('jobs.apply');



// Job search and apply
Route::get('/search-jobs', [JobSearchController::class, 'index'])->name('jobs.search');
Route::post('/apply-job/{jobId}', [JobSearchController::class, 'apply'])->name('jobs.apply');


// View applicants for a job
Route::get('/jobs/applicants', [JobController::class, 'viewApplicants'])->name('jobs.applicants');

// Hire applicant
Route::put('/jobs/applications/{applicationId}/hire', [JobController::class, 'hireApplicant'])->middleware('auth')->name('jobs.hire');


// Fire applicant
Route::put('/jobs/fire/{application}', [JobController::class, 'fireApplicant'])->name('jobs.fire');



// Show the form to give a rating for a specific job seeker (user)
Route::get('/ratings/create/{userId}', [RatingController::class, 'create'])->name('ratings.create');

// Store the rating submitted by the employer
Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');


Route::put('/jobs/applications/{applicationId}/hire', [JobController::class, 'hireApplicant'])->middleware('auth')->name('jobs.hire');


//view
Route::get('/applicants/{user}', [ProfileController::class, 'viewApplicant'])->name('applicants.view');


//Payment
// Employer view to see hired workers and pay
Route::get('/employer/payments', [\App\Http\Controllers\PaymentController::class, 'index'])->name('employer.payments');

// Payment action (POST or GET, your choice)
Route::post('/employer/pay/{taskId}', [\App\Http\Controllers\PaymentController::class, 'pay'])->name('employer.pay');


//Badges
Route::get('/endorsements', [EndorsementController::class, 'index'])->middleware('auth')->name('endorsements.index');







