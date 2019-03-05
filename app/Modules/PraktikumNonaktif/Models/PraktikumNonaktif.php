<?php
namespace App\Modules\PraktikumNonaktif\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PraktikumNonaktif extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'praktikum';
  protected $fillable = ['*'];

}
