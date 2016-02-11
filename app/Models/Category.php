<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'category';
	public $timestamps = false;

	public function user()
	{
		return $this->belongsTo('App\Models\User','user_id');
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