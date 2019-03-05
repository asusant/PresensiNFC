<?php
namespace App\Modules\RuangKuliah\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RuangKuliah extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'ruang_kuliah';
  protected $fillable = ['*'];

}
