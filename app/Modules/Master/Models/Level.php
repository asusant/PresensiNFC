<?php

namespace App\Modules\Master\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Master extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];
}
