<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerEntity extends Model
{
    /** @use HasFactory<\Database\Factories\PartnerEntityFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'qualification_field_work',
        'role_responsibility',
        'projectproposal_id'

    ];
    public function projectproposal()
    {
        return $this->belongsTo(ProjectProposal::class);
    }
}
