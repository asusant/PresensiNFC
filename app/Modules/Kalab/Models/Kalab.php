<?php
namespace App\Modules\Kalab\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kalab extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'kalab';
  protected $fillable = ['*'];

}
