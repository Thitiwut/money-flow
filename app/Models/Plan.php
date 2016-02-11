<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plan';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function months()
    {
        return $this->hasMany('App\Models\Monthly', 'plan_id');
    }
    public function restricts()
    {
        return $this->hasMany('App\Models\Restrict', 'plan_id');
    }
}
