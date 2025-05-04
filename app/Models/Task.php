<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $fillable = [
        'job_id',
        'job_seeker_id',
        'name',
        'status',
        'approved',
        'payment_amount',
        'payment_status',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function seeker()
    {
        return $this->belongsTo(\App\Models\User::class, 'job_seeker_id');
    }
}
