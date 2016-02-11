<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
	protected $table = 'finance';

	public function daily()
	{
		return $this->belongsTo('App\Models\Daily','daily_id');
	}
	public function category()
	{
		return $this->belongsTo('App\Models\Category','category_id');
	}
}