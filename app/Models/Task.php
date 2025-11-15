<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_name',
        'duration',
        'responsible',
        'description',
        'start_date',
        'end_date',
        'real_start_date',
        'real_end_date',
        'project_id',
    ];

    public function uesrs()
    {
        return $this->belongsToMany(User::class,'user_task');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function tasksteps()
    {
        return $this->hasMany(TaskStep::class);
    }
}
