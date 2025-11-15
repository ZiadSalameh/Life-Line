<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityMethodology extends Model
{
    use HasFactory;
    
    protected $table = 'activity_methodologies';
    
    protected $fillable = [
        'projectproposal_id',
        'activity_methodology_name',
        'proposed_implementation_period',
        'logistical_requirements',
        'outputs'
    ];
    
    public function projectProposal()
    {
        return $this->belongsTo(ProjectProposal::class,'projectproposal_id');
    }
}
