<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectProposal extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectProposalFactory> */
    use HasFactory;

    protected $fillable = [
        'office_id',
        'request_no',
        'requset_date',
    ];
    public function project()
    {
        return $this->belongsTo(ProjectDescription::class);
    }

    public function obectives()
    {
        return $this->hasMany(Objective::class);
    }


    public function activitiesMonitoring()
    {
        return $this->hasMany(ActivityMonitoring::class);
    }

    public function partnerEntity()
    {
        return $this->hasMany(PartnerEntity::class);
    }

    public function activityMethodologies()
    {
        return $this->hasMany(ActivityMethodology::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
