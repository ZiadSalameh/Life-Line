<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /** @use HasFactory<\Database\Factories\ActivityFactory> */
    use HasFactory;
    protected $fillable = [
        'objective_id',
        'activity_name',
        'expected_outcome',
        'brief_project',


    ];
    public function objective(){
        return $this->belongsTo(Objective::class);
    }
}
