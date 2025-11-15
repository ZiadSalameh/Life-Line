<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityMonitoring extends Model
{
    use HasFactory;
    
    protected $table = 'activity__monitorings';

    protected $fillable = [
        'projectproposal_id',
        'name',
        'monitors_name',
        'date_tracking',
        'monitors_note',
        'monitroing_mechanism'
    ];

    protected $casts = [
        'date_tracking' => 'date',
    ];

    public function projectProposal()
    {
        return $this->belongsTo(ProjectProposal::class,'projectproposal_id');
    }
}
