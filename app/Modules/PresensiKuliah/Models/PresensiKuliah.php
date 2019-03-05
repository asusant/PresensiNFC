<?php
namespace App\Modules\PresensiKuliah\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PresensiKuliah extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'presensi_kuliah';
  protected $fillable = ['*'];

}
