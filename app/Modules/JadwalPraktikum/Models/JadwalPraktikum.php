<?php
namespace App\Modules\JadwalPraktikum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalPraktikum extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'jadwalpraktikum';
  protected $fillable = ['*'];

}
