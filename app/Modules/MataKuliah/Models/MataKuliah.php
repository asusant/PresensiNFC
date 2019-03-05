<?php
namespace App\Modules\MataKuliah\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MataKuliah extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'mata_kuliah';
  protected $fillable = ['*'];

}
