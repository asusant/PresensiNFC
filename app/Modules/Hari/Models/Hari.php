<?php
namespace App\Modules\Hari\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hari extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'hari';
  protected $fillable = ['*'];

}
