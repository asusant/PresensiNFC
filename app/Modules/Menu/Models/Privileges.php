<?php

namespace App\Modules\Menu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Privileges extends Model
{
	use SoftDeletes;

	protected $table = 'previleges';
	protected $dates = ['deleted_at'];

	public function menu()
	{
		return $this->hasMany('App\Models\Menu', 'id', 'id_menu');
	}

	public function FunctionName()
	{
		# code...
	}

}
