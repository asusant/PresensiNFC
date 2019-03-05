<?php
namespace App\Modules\Modul\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modul extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'modul';
  protected $fillable = ['*'];

}
