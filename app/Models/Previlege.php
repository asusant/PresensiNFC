<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Previlege extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];

	public function menu()
	{
			return $this->hasMany('App\Models\Menu', 'id', 'id_menu');
	}

}
