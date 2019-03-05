<?php
namespace App\Modules\Praktikum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Praktikum extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'praktikum';
  protected $fillable = ['*'];

}
