<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\MeetingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meeting extends Model
{
    use HasFactory;
    
    protected static function newFactory()
    {
        return MeetingFactory::new();
    }
    protected $fillable =
    [
        'meeting_no',
        'description',
        'DateTime',
    ];


    //many to many
    public function users()
    {
        return $this->belongsToMany(User::class,'user_meeting');
    }


    public function costs()
    {
        return $this->BelongsToMany(Cost::class, 'meeting_cost');
    }

    public function boardDees()
    {
        return $this->hasMany(BoardDee::class);
    }
}
