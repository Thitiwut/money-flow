<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{
	protected $table = 'finance';

	public function daily()
	{
		return $this->belongTo('App\Models\Daily','daily_id');
	}
	public function category()
	{
		return $this->belongTo('App\Models\Category','category_id');
	}
}