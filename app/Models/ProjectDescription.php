<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectDescription extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectDescriptionFactory> */
    use HasFactory;

    protected $fillable = [
        'projectproposal_id',
        'project_proposal_name',
        'duration_project_proposal',
        'target_area',
        'target_group',
        'no_of_direct_benif',
        'estimate_cost',
        'partners',
        'over_all_project_goal'
    ];
    public function project_proposal()
    {
        return $this->belongsTo(ProjectProposal::class);
    }
}
