<?php
namespace App\Modules\Semester\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Semester extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'semester';
  protected $fillable = ['*'];

}
