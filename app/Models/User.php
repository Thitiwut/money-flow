<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';

    public function categories()
    {
        return $this->hasMany('App\Models\Category', 'user_id');
    }
    public function plans()
    {
        return $this->hasMany('App\Models\Plan', 'user_id');
    }
    public function feedbacks()
    {
        return $this->hasMany('App\Models\Feedback', 'user_id');
    }
}
