<?php




namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class JobApplication extends Model
{
    use HasFactory;


    protected $table = 'job_applications'; // Explicitly specify the table name


    // Define any relationships (if needed)
    public function user()
    {
        return $this->belongsTo(User::class, 'job_seeker_id');
    }
}
