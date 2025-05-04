<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Rating extends Model
{
    use HasFactory;


    protected $fillable = [
        'rater_id',
        'user_id',
        'job_id',
        'rating',
        'feedback',
    ];


    // Relationships
    public function rater()
    {
        return $this->belongsTo(User::class, 'rater_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
