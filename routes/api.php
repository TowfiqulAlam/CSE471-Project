<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;  // Ensure to import the controller

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "api" middleware group. Now create something great!
|
*/

// Example of a GET route
Route::middleware('auth:sanctum')->put('job-applications/{id}/status', [JobApplicationController::class, 'updateStatus']);

use App\Http\Controllers\JobApplicationController;

Route::put('job-applications/{id}/status', [JobApplicationController::class, 'updateStatus']);

Route::get('testing',function (){
    return 'tesing';

});
