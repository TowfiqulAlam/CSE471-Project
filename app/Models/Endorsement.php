<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endorsement extends Model
{
    protected $fillable = ['task_id', 'tag'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
