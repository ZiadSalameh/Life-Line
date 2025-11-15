<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStep extends Model
{
    use HasFactory;
    protected $fillable = [
        'step',
        'duration',
        'description',
        'start_date',
        'end_date',
        'real_start_date',
        'real_end_date',
        'step',
        'task_id'
    ];


      public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function costs()
    {
        return $this->belongsToMany(Cost::class,'coast_step');
    }

}
