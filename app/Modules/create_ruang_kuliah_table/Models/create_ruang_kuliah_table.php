<?php
namespace App\Modules\create_ruang_kuliah_table\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class create_ruang_kuliah_table extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'create_ruang_kuliah_table';
  protected $fillable = ['*'];

}
