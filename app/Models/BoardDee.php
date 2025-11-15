<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\BoardDeeFactory;

class BoardDee extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return BoardDeeFactory::new();
    }
    //
    protected $fillable =
    [
        'board_no',
        'boar_dee_date',
        'description',
        'voted',
        'meeting_id'
    ];



    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    public function  projects()
    {
        return $this->hasMany(Project::class);
    }
}
