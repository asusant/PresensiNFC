<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserLevel extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];

	public static function isDosen($id_user)
	{
		return UserLevel::where('id_user', $id_user)->where('id_level', 4)->take(1)->count(); #default dosen
	}
}
