<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{
	protected $table = 'restrict';
	public $timestamps = false;

	public function plan()
	{
		return $this->belongTo('App\Models\Plan','plan_id');
	}
	public function category()
	{
		return $this->belongTo('App\Models\Category','category_id');
	}
}