<?php
namespace App\Modules\PraktikumDosen\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PraktikumDosen extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'praktikum';
  protected $fillable = ['*'];

}
