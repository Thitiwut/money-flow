<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
	protected $table = 'plan';

	public function user()
	{
		return $this->belongTo('App\Models\User','user_id');
	}
	public function months()
	{
		return $this->hasMany('App\Models\Monthly','plan_id');
	}
}