<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Previlege;

class Menu extends Model
{
    use SoftDeletes;

		protected $dates = ['deleted_at'];

		public function previleges()
		{
				return $this->hasMany('Previlege', 'id_menu');
		}
}
