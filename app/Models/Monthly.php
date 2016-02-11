<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monthly extends Model
{
	protected $table = 'montly';

	public function plan()
	{
		return $this->belongsTo('App\Models\Plan','plan_id');
	}
}