<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];

	public function previleges()
	{
			return $this->hasMany('App/Previleges', 'id_menu');
	}

	public function user_levels()
	{
			return $this->hasMany('App\Models\UserLevel', 'id_level');
	}
}
