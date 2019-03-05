<?php
namespace App\Modules\PraktikumDosenNonaktif\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PraktikumDosenNonaktif extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'praktikumdosennonaktif';
  protected $fillable = ['*'];

}
