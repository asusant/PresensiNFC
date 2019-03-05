<?php
namespace App\Modules\HistoryPraktikum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoryPraktikum extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'historypraktikum';
  protected $fillable = ['*'];

}
