<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }
    
    public function receiver() {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    
    public function job() {
        return $this->belongsTo(Job::class);
    }
    
    protected $fillable = ['job_id', 'sender_id', 'receiver_id', 'message'];

}
