<?php
namespace App\Modules\TipeKehadiran\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipeKehadiran extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'tipe_kehadiran';
  protected $fillable = ['*'];

}
