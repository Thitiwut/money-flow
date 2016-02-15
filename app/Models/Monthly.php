<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monthly extends Model
{
    protected $table = 'monthly';

    public function plan()
    {
        return $this->belongsTo('App\Models\Plan', 'plan_id');
    }
    public function days()
    {
        return $this->hasMany('App\Models\Daily', 'monthly_id');
    }
}
