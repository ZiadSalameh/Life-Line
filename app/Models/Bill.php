<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{

    protected $fillable =
    [
        'amount',
        'cost_id'
    ];


      public function cost()
    {
        return $this->belongsTo(Cost::class);
    }
}
