<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{
	protected $table = 'daily';

	public function monthly()
	{
		return $this->belongTo('App\Models\Plan','monthly_id');
	}
	public function finances()
	{
		return $this->hasMany('App\Models\Finance','daily_id');
	}
}