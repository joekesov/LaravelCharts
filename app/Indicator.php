<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Indicator extends Model
{
    protected $table = 'indicator';

    public function device()
    {
        return $this->belongsTo('App\Device');
    }
}
