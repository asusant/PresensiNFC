<?php
namespace App\Modules\Laboratorium\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laboratorium extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'laboratorium';
  protected $fillable = ['*'];

}
