<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    use HasFactory;

     protected $fillable = [
        'element_id',
        'pay_date'
    ];




    public function element()
    {
        return $this->belongsTo(Element::class);
    }

    public function meetings()
    {
        return $this->BelongsToMany(Meeting::class,'meeting_cost');
    }


    public function bill()
    {
        return $this->hasOne(Cost::class);
    }

     public function costs()
    {
        return $this->belongsToMany(TaskStep::class,'coast_step');
    }
}
