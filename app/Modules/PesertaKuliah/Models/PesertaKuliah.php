<?php
namespace App\Modules\PesertaKuliah\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PesertaKuliah extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'peserta_kuliah';
  protected $fillable = ['*'];

}
