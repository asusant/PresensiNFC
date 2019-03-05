<?php
namespace App\Modules\PresensiPraktikum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pertemuan extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'pertemuan';
  protected $fillable = ['*'];

}
