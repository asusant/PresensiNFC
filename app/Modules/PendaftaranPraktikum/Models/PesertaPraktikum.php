<?php
namespace App\Modules\PendaftaranPraktikum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PesertaPraktikum extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'peserta_praktikum';
  protected $fillable = ['*'];

}
