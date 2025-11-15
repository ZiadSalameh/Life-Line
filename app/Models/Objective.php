<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{
    /** @use HasFactory<\Database\Factories\ObjectiveFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'projectproposal_id'
    ];

    public function projectproposal()
    {
        return $this->belongsTo(ProjectProposal::class);
    }
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
