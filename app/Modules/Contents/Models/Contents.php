<?php
namespace App\Modules\Contents\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contents extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'contents';
  protected $fillable = ['*'];

}
