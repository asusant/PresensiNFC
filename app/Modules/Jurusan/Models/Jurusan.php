<?php
namespace App\Modules\Jurusan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jurusan extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'jurusan';
  protected $fillable = ['*'];

}
