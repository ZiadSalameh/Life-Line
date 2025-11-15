<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'board_dee_id',
        'project_no',
        'project_name',
        'start_date',
        'end_date',
        'real_start_date',
        'real_end_date',
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'real_start_date',
        'real_end_date',
        'created_at',
        'updated_at',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function  boardDee()
    {
        return $this->belongsTo(BoardDee::class);
    }
}
