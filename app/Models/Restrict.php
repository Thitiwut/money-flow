<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restrict extends Model
{
	protected $table = 'restrict';
	public $timestamps = false;

	public function plan()
	{
		return $this->belongsTo('App\Models\Plan','plan_id');
	}
	public function category()
	{
		return $this->belongsTo('App\Models\Category','category_id');
	}
}