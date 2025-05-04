<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'jobs';

    // Specify the fillable attributes to protect against mass-assignment vulnerabilities
    protected $fillable = [
        'user_id', // Employer posting the job
        'title',
        'description',
        'location',
        'salary',
        'status',
        'starting_time',
        'ending_time',
    ];

    // Define a relationship with the User model (Employer)
    public function employer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'job_task');
    }


    public function hiredApplicant()
    {
        return $this->hasOne(Application::class)->where('status', 'hired')->with('user');
    }



}
