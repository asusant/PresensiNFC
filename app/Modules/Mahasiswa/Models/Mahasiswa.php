<?php
namespace App\Modules\Mahasiswa\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mahasiswa extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'mahasiswa';
  protected $fillable = ['*'];

}
