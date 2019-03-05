<?php
namespace App\Modules\Dosen\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dosen extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'dosen';
  protected $fillable = ['*'];

}
