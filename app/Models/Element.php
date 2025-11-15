<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Element extends Model
{

    use HasFactory;


    protected $fillable =
    [
        'element_name',
        'description'
    ];

    public function costs()
    {
        return $this->hasMany(Cost::class);
    }
}
