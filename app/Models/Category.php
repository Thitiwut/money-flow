<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{
	protected $table = 'category';
	public $timestamps = false;

	public function user()
	{
		return $this->belongTo('App\Models\User','user_id');
	}
	public function restricts()
	{
		return $this->hasMany('App\Models\Restrict','category_id');
	}
	public function finances()
	{
		return $this->hasMany('App\Models\Finance','category_id');
	}
}