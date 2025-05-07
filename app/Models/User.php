<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'date_of_birth', 'occupation', 'user_type'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Ratings the user has received (as a job seeker)
    public function receivedRatings()
    {
        return $this->hasMany(\App\Models\Rating::class, 'user_id');
    }

    // Ratings the user has given (as an employer)
    public function givenRatings()
    {
        return $this->hasMany(\App\Models\Rating::class, 'rater_id');
    }

    // Jobs posted by the user (employer)
    public function jobs()
    {
        return $this->hasMany(Job::class, 'user_id');
    }

    // Jobs applied to by the user (job seeker)
    public function applications()
    {
        return $this->hasMany(\App\Models\Application::class, 'job_seeker_id');
    }

    // Tasks assigned to the user (job seeker)
    public function tasks()
    {
        return $this->hasMany(\App\Models\Task::class, 'job_seeker_id');
    }

    // Jobs the user has applied for (job seeker)
    public function appliedJobs()
    {
        return $this->belongsToMany(Job::class, 'job_applications')
                    ->withPivot('status')
                    ->wherePivot('status', 'hired');
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function availability()
    {
        return $this->hasMany(Availability::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'user_id');
    }

    public function portfolio()
    {
        return $this->hasOne(Portfolio::class);
    }


    public function sentMessages() 
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
    
    public function receivedMessages() 
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
    

}
