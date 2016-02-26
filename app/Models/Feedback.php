<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
	protected $table = 'feedback';

	public function user()
	{
		return $this->belongsTo('App\Models\User','user_id');
	}
}