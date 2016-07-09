<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    protected $table = 'checklist';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
